<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use App\Models\Availabilities;
use App\Models\Lawyer_profiles;
use App\Models\Specialization;
use App\Models\Consultation;
use App\Models\Reviews;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class LawyerProfilesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lawyers = User::where('role', 'lawyer')->with('lawyerProfile', 'specializations')->get();
        return view('admin.lawyers.index', compact('lawyers'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $allSpecializations = Specialization::all();
        return view('admin.lawyers.create', [
    'allSpecializations' => $allSpecializations
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'specialization' => 'required|array|min:1',
            'location' => 'nullable|string|max:255',
            'experience_years' => 'nullable|integer|min:0',
            'bio' => 'nullable|string',
            'status' => 'nullable|in:active,inactive,pending,banned',
        ]);

        $lawyer = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'lawyer',
            'status' => $request->status ?? 'pending',
            'password' => Hash::make('123456'),
        ]);

        $lawyer->lawyerProfile()->create([
            'user_id' => $lawyer->id,
            'specialization' => '',
            'bio' => $request->bio ?? '',
            'location' => $request->location ?? '',
            'experience_years' => $request->experience_years ?? 0,
            'is_verified' => false,
            'rating' => $request->rating ?? 0,
        ]);
        $lawyer->specializations()->attach($request->specialization);

        return redirect()->route('admin.lawyers.index')->with('success', 'Đã lưu thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Lấy thông tin luật sư kèm hồ sơ và các lịch hẹn
        $lawyer = User::where('role', 'lawyer')
            ->with(['lawyerProfile', 'specializations', 'availabilities'])
            ->findOrFail($id);

        $bookedSlots = Appointments::where('lawyer_id', $id)
            ->where('appointment_date', '>=', now()->toDateString())
            ->whereIn('status', ['pending', 'confirmed'])
            ->get();

        return view('admin.lawyers.show', compact('lawyer', 'bookedSlots'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $id=Auth::id();
        $lawyer=Lawyer_Profiles::with('user', 'specializations')->where('user_id', $id)->firstOrFail();
        $allSpecializations = Specialization::all();
        return view('lawyer.profile.edit', compact('lawyer', 'allSpecializations'));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request)
    {
        $id = Auth::id();
        $lawyer = Lawyer_Profiles::with('user')->where('user_id', $id)->firstOrFail();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'experience_years' => 'nullable|integer|min:0',
            'bio' => 'nullable|string',
            'specializations' => 'nullable|array',
        ]);

        // 1. Cập nhật lại cái tên thật vào bảng users
        $lawyer->user->update(['name' => $data['name']]);

        // 2. Cập nhật hồ sơ (Bỏ 'name' ra để không bị lỗi Unknown column)
        $lawyer->update($request->only(['location', 'experience_years', 'bio']));

        // 3. Cập nhật chuyên môn (Bảng trung gian)
        if ($request->has('specializations')) {
            $lawyer->specializations()->sync($request->specializations);
        }

        // 4. Chuyển hướng về đúng view Index
        return redirect()->route('lawyer.profile')->with('success', 'Updated!');
    }

    public function updateAccount(Request $request)
    {
        $id = Auth::id();

        $validatedAccount = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        User::where('id', $id)->update($validatedAccount);

        return back()->with('success', 'Account information updated.');
    }

    public function updateProfile(Request $request)
    {
        // dd($request->all());
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validatedProfile = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'experience_years' => 'nullable|integer|min:0',
            'bio' => 'nullable|string',
            'specializations' => 'nullable|array',
        ]);

        $user->lawyerProfileProfile()->updateOrCreate(
            ['user_id' => $user->id],
                [
                    'name' => $validatedProfile['full_name'], // or 'name'
                    'location' => $validatedProfile['location'],
                    'experience_years' => $validatedProfile['experience_years'],
                    'bio' => $validatedProfile['bio'],
                    'specializations' => $validatedProfile['specializations'],
                ]
        );
        return back()->with('success', 'Profile information updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        User::where('id', $id)->where('role', 'lawyer')->delete();
        return back()->with('success', 'Đã xóa luật sư thành công!');
    }

     public function settings()
    {
        $user = Auth::user();
        return view('lawyer.settings', compact('user'));
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

        return back()->with('success', 'Account information updated successfully!');
    }

    public function pendingList(Request $request)
    {
        $id=Auth::id();
        $pending=Appointments::where('lawyer_id', $id)->where('status', 'pending')->get();
        return view('lawyer.appointment.pending', compact('pending'));
    }

    public function confirmedList(Request $request)
    {
        $id=Auth::id();
        $confirmed=Appointments::where('lawyer_id', $id)->where('status', 'confirmed')->get();
        return view('lawyer.appointment.confirmed', compact('confirmed'));
    }

    public function completedList(Request $request)
    {
        $id=Auth::id();
        $completed=Appointments::where('lawyer_id', $id)->where('status', 'completed')->get();
        return view('lawyer.appointment.completed', compact('completed'));
    }

    public function profile(){
        $id=Auth::id();
        $lawyer=Lawyer_Profiles::with('specializations')->where('user_id', $id)->firstOrFail();
        $lawyers=Availabilities::where('lawyer_id', $lawyer->id)->first();
        $rate=Reviews::with('user')->where('lawyer_id', $id)->get();
        $date=Appointments::where('lawyer_id', $id)->get();
        return view('lawyer.profile.index', compact('lawyers','date','rate','lawyer'));
    }

    public function question(){
        $id = Auth::id();
        $storequestion=Consultation::with('lawyer', 'client')->where('lawyer_id', $id)->get();
        return view('lawyer.question.index', compact('storequestion'));
    }

    public function answer(Request $request){
        $request->validate([
            'answer' => 'required',
            'consultation_id' => 'required|exists:consultations,id'
        ]);
        $consultation = Consultation::find($request->consultation_id);
        $consultation->answer = $request->answer;
        $consultation->save();
        return redirect()->back()->with('success', 'Your reply has been submitted successfully!');
    }

    public function reanswer(Request $request, $id){
        $request->validate([
            'answer'=> 'required',

        ]);
        $updateanswer=Consultation::findOrFail($id);
        $updateanswer->update([
            'answer'=>$request->answer
        ]);
        return redirect()->route('lawyer.question')->with('success', 'your answer is updated successfully');
    }

    public function blog(){
        return view('lawyer.blog.index');
    }

    public function index1(Request $request)
    {
       $lawyers = Lawyer_Profiles::with(['user', 'specializations'])
        // Search theo tên luật sư
        ->when($request->keyword, function ($q) use ($request) {
            $q->whereHas('user', function ($u) use ($request) {
                $u->where('name', 'like', '%' . $request->keyword . '%');
            });
        })

        // Filter theo specialization
        ->when($request->specialization, function ($q) use ($request) {
            $q->whereHas('specializations', function ($s) use ($request) {
                $s->where('specialization_id', $request->specialization);
            });
        })

        // Filter theo location
        ->when($request->location, function ($q) use ($request) {
            $q->where('location', 'like', '%' . $request->location . '%');
        })

        ->paginate(5)
        ->withQueryString(); // giữ param khi chuyển page

        $specializations = Specialization::all();

        return view('pages.findLawyer', compact('lawyers', 'specializations'));

    }

}
