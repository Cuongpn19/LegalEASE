<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use App\Models\Lawyer_profiles;
use App\Models\Specialization;
use App\Models\Consultation;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        User::where('id', $id)->where('role', 'lawyer')->delete();
        return back()->with('success', 'Đã xóa luật sư thành công!');
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
        return view('lawyer.profile.index', compact('lawyer'));
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
}
