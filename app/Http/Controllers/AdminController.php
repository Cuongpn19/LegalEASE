<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Appointments;
use App\Models\Legal_updates;
use App\Models\Reviews;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Http\Controllers\Controller;
use App\Models\Lawyer_profiles;
use App\Models\Specialization;

class AdminController extends Controller
{

    public function dashboard()
    {
    // 1. Thống kê tổng quát
    $status = [
        'total_clients' => User::where('role', 'client')->count(),
        'total_lawyers' => User::where('role', 'lawyer')->count(),
        'pending_appointments' => Appointments::where('status', 'pending')->count(),
        'confirmed_appointments' => Appointments::where('status', 'confirmed')->count(),
    ];

    // 2. Dữ liệu biểu đồ
    $chartData = [
        'labels' => ['Pending', 'Confirm', 'Complete', 'Cancel'],
        'data' => [
            $status['pending_appointments'],
            $status['confirmed_appointments'],
            Appointments::where('status', 'completed')->count(),
            Appointments::where('status', 'cancelled')->count(),
        ]
    ];

        // 3. Danh sách cho bảng gộp
        $lawyers = User::where('role', 'lawyer')->with('lawyerProfile')->get();
        $clients = User::where('role', 'client')->get();

        // Truyền biến rời $totalClients để tránh lỗi Undefined variable
        $totalClients = $status['total_clients'];

        return view('admin.dashboard', compact('status', 'chartData', 'lawyers', 'clients', 'totalClients'));
    }


    public function manageUsers()
    {
        // Quản lý User: Hiển thị danh sách và lọc
        $lawyers = User::where('role', 'lawyer')->with('lawyerProfile')->get();
        $clients = User::where('role', 'client')->get();

        return view('admin.users.index', compact('lawyers', 'clients'));
    }

    public function approveLawyer($id)
    {
        // Phê duyệt luật sư (Chuyển từ pending sang active)
        $lawyer = User::findOrFail($id);
        // Kiểm tra nếu đúng là luật sư và đang ở trạng thái chờ
        if ($lawyer->role === 'lawyer' && $lawyer->status === 'pending') {
            $lawyer->status = 'active';
            $lawyer->save();

            return redirect()->back()->with('success', 'Đã phê duyệt luật sư ' . $lawyer->name . ' thành công!');
        }

        return redirect()->back()->with('error', 'Không thể phê duyệt tài khoản này.');
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        // Chuyển đổi trạng thái
        if ($user->status === 'active') {
            $user->status = 'inactive';
            $message = 'Đã khóa tài khoản người dùng ' . $user->name;
        } else {
            $user->status = 'active';
            $message = 'Đã mở khóa tài khoản người dùng ' . $user->name;
        }

        $user->save();

        return redirect()->back()->with('success', $message);
    }

    public function revertPending($id)
    {
        $user = User::findOrFail($id);

        // Chỉ thực hiện nếu trạng thái hiện tại là active
        if ($user->status === 'active') {
            $user->status = 'pending';
            $user->save();

            return redirect()->back()->with('success', 'Đã chuyển trạng thái người dùng ' . $user->name . ' về Chờ duyệt.');
        }

        return redirect()->back()->with('error', 'Thao tác không hợp lệ.');
    }

    public function indexClients()
    {
        $clients = User::where('role', 'client')->get();
        return view('admin.clients.index', compact('clients'));
    }

    public function destroyClient($id)
    {
        $client = User::findOrFail($id);
        // Thay vì xóa vĩnh viễn, bạn có thể đổi trạng thái thành "Khóa" như giao diện hiển thị
        $client->delete();
        return back()->with('success', 'Đã khóa tài khoản khách hàng thành công!');
    }

    public function reports()
    {
        $feedbacks = Reviews::with(['appointment.lawyer', 'appointment.client'])
                    ->latest()
                    ->get();
        return view('admin.reports', compact('feedbacks'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'Đã xóa người dùng ' . $user->name . ' thành công.');
    }

    public function settings()
{
    $user = Auth::user();
    return view('admin.settings', compact('user'));
}

public function updateSettings(Request $request)
{
    // Lấy đối tượng user hiện tại
    /** @var \App\Models\User $user */
    $user = Auth::user();

    // Kiểm tra nếu user chưa đăng nhập (đề phòng)
    if (!$user) {
        return redirect()->route('login');
    }

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => ['nullable', 'confirmed', Password::defaults()],
    ], [
        'name.required' => 'Vui lòng nhập họ tên.',
        'email.unique' => 'Email này đã có người sử dụng.',
        'password.confirmed' => 'Xác nhận mật khẩu không khớp.'
    ]);

    // Cập nhật thông tin
    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return back()->with('success', 'Cập nhật thông tin tài khoản thành công!');
}

    public function edit($id)
    {
        $lawyer = User::with(['lawyerProfile', 'specializations'])->findOrFail($id);
        $allSpecializations = Specialization::all();

        return view('admin.lawyers.edit', compact('lawyer', 'allSpecializations'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive,pending,banned',
            'specializations' => 'nullable|array',
            'location' => 'nullable|string',
            'experience_years' => 'nullable|integer',
            'bio' => 'nullable|string',
        ]);

        $lawyer = User::findOrFail($id);

        // 1. Update bảng Users
        $lawyer->name = $request->name;
        $lawyer->status = $request->status;
        $lawyer->save();

        // 2. Update bảng Profile
        $lawyer->lawyerProfile()->updateOrCreate(
            ['user_id' => $lawyer->id],
            $request->only(['bio', 'location', 'experience_years'])
        );

        // 3. LƯU DATA CHUYÊN MÔN
        // Thêm log hoặc kiểm tra để chắc chắn dữ liệu vào đây
        if ($request->has('specializations')) {
            $lawyer->specializations()->sync($request->input('specializations'));
        } else {
            $lawyer->specializations()->detach(); // Xóa sạch nếu không chọn cái nào
        }

        return redirect()->route('admin.lawyers.index')->with('success', 'Updated successfully!');
    }
}
