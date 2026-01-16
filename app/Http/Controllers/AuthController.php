<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function create() {
        return view('auth.register');
    }

    public function store(Request $request) {
        // dd($request->all());
            // 1. Validate dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed',
            'role' => 'required|in:client,lawyer', // Chỉ cho phép 2 giá trị này
        ]);

        // 2. Tạo User mới
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, // Lưu role vào db
            'status' => 'active',
        ]);

            if ($user->role === 'lawyer') {
            $user->lawyerProfile()->create([
                'bio' => '',
                'location' => '',
                'experience_years' => 0,
                // Thêm các trường mặc định khác nếu cần
            ]);
        }

        return redirect()->route('login')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (!Auth::user()->status) {
                Auth::logout();
                return back()->withErrors(['email' => 'Account is disabled']);
            }

            return match (Auth::user()->role) {
                'admin'  => redirect('/admin/dashboard'),
                'lawyer' => redirect('/lawyer/dashboard'),
                default  => redirect('/client/dashboard'),
            };
        }

        return back()->withErrors([
            'email' => 'Invalid email or password. Try again!',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        // Tạo token giả lập
        $token = Str::random(64);
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now()
        ]);

        // Trong thực tế sẽ gửi mail ở đây. Hiện tại ta redirect sang trang nhập pass mới kèm token.
        return redirect()->route('password.reset', ['token' => $token])
                        ->with('success', 'Hệ thống đã xác nhận email (Simulated).');
    }

    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:3|confirmed',
        ]);

        // Kiểm tra token hợp lệ
        $reset = DB::table('password_resets')
                    ->where(['email' => $request->email, 'token' => $request->token])
                    ->first();

        if (!$reset) return back()->withErrors(['email' => 'Token không hợp lệ!']);

        // Cập nhật pass
        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        // Xóa token đã dùng
        DB::table('password_resets')->where(['email' => $request->email])->delete();

        return redirect()->route('login')->with('success', 'Mật khẩu đã được đổi thành công!');
    }

}
