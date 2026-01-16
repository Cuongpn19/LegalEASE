<?php

namespace App\Http\Controllers;

use App\Models\Availabilities;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvailabilitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $availabilities = Auth::user()->availabilities; // Lấy lịch của luật sư đang đăng nhập
        return view('admin.availabilities.index', compact('availabilities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'lawyer_id' => 'required|exists:users,id',
            'day_of_week' => 'required|string',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        // Chuẩn hóa giờ về định dạng H:i:s để khớp tuyệt đối với logic so sánh
        $startTime = Carbon::parse($request->start_time)->format('H:i:s');
        $endTime = Carbon::parse($request->end_time)->format('H:i:s');

        // Sử dụng updateOrInsert để tránh tạo trùng lặp khung giờ cho cùng 1 người
        Availabilities::updateOrCreate(
            [
                'lawyer_id' => $request->lawyer_id,
                'day_of_week' => $request->day_of_week,
                'start_time' => $startTime,
            ],
            [
                'end_time' => $endTime,
                'status' => 'available',
            ]
        );

        return back()->with('success', 'Đã mở khung giờ rảnh thành công!');
    }
    /**
     * Display the specified resource.
     */
    public function show(Availabilities $availabilities)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $availability = Availabilities::findOrFail($id);
        $lawyers = User::where('role', 'lawyer')->get();
        return view('admin.availabilities.edit', compact('availability', 'lawyers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
        'lawyer_id' => 'required',
        'day_of_week' => 'required',
        'start_time' => 'required',
        'end_time' => 'required',
    ]);

    $availability = Availabilities::findOrFail($id);
    $availability->update([
        'lawyer_id' => $request->lawyer_id,
        'day_of_week' => $request->day_of_week,
        'start_time' => Carbon::parse($request->start_time)->format('H:i:s'),
        'end_time' => Carbon::parse($request->end_time)->format('H:i:s'),
    ]);

    return redirect()->route('admin.appointments.index')->with('success', 'Cập nhật giờ rảnh thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $availability = Availabilities::findOrFail($id);
        $availability->delete();

        return back()->with('success', 'Đã xóa khung giờ rảnh của luật sư.');
    }
}
