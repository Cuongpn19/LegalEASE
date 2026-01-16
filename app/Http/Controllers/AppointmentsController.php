<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use App\Models\Availabilities;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\AppointmentCancelled;
use App\Mail\AppointmentCompleted;
use App\Mail\AppointmentConfirmed;
use App\Mail\AppointmentNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class AppointmentsController extends Controller
{
    public function index()
    {
        $appointments = Appointments::with(['client', 'lawyer'])->latest()->paginate(10);
        $lawyers = User::where('role', 'lawyer')->get();
        return view('admin.appointments.index', compact('appointments', 'lawyers'));
    }

    public function updateStatus(Request $request, $id)
    {
        $appointment = Appointments::findOrFail($id);
        $oldStatus = $appointment->status;

        $appointment->update(['status' => $request->status]);

        $clientEmail = $appointment->client_email ?? ($appointment->client ? $appointment->client->email : null);

        if ($clientEmail && $oldStatus != $request->status) {
            switch ($request->status) {
                case 'confirmed':
                    Mail::to($clientEmail)->send(new AppointmentConfirmed($appointment));
                    break;
                case 'completed':
                    Mail::to($clientEmail)->send(new AppointmentCompleted($appointment));
                    break;
                case 'cancelled':
                    Mail::to($clientEmail)->send(new AppointmentCancelled($appointment));
                    break;
            }
        }

        return redirect()->back()->with('success', 'Đã phê duyệt và gửi email thông báo cho khách hàng.');
    }

    public function showBookingForm($id)
    {
        $lawyer = User::with('availabilities')->findOrFail($id);

        $bookedSlots = Appointments::where('lawyer_id', $id)
            ->whereDate('appointment_date', '>=', now()->toDateString())
            ->whereDate('appointment_date', '<=', now()->addDays(6)->toDateString())
            ->whereIn('status', ['pending', 'confirmed'])
            ->get(); // Lấy tất cả lịch hẹn trong khoảng 7 ngày tới

        return view('client.booking', compact('lawyer', 'bookedSlots'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để đặt lịch.');
        }

        $request->validate([
            'lawyer_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required', // Đã đồng bộ tên
        ]);

        $dateOnly = Carbon::parse($request->appointment_date)->toDateString();
        $timeOnly = Carbon::parse($request->start_time)->format('H:i:s'); // Format chuẩn DB

        // Kiểm tra trùng lịch sử dụng cột start_time mới
        $exists = Appointments::where('lawyer_id', $request->lawyer_id)
            ->where('appointment_date', $dateOnly)
            ->where('start_time', $timeOnly)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'Khung giờ này vừa có người đặt, vui lòng chọn giờ khác.');
        }

        Appointments::create([
            'lawyer_id' => $request->lawyer_id,
            'client_id' => Auth::id(),
            'appointment_date' => $dateOnly,
            'start_time' => $timeOnly,
            'status' => 'pending',
            'notes' => $request->notes ?? '',
        ]);

        return back()->with('success', 'Đặt lịch thành công!');
    }

    public function publicCreate()
    {
        $lawyers = User::where('role', 'lawyer')->get();
        $clients = User::where('role', 'client')->get(); // Lấy danh sách khách hàng để nạp thủ công
        return view('admin.appointments.public_create', compact('lawyers', 'clients'));
    }

    public function publicStore(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:users,id',
            'lawyer_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'notes' => 'nullable|string|max:1000',
        ]);

        $date = Carbon::parse($request->appointment_date)->toDateString();
        $time = Carbon::parse($request->start_time)->format('H:i:s');

        $exists = Appointments::where('lawyer_id', $request->lawyer_id)
            ->where('appointment_date', $date)
            ->where('start_time', $time)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'Khung giờ này đã có người đặt.');
        }

        $appointment = Appointments::create([
            'client_id' => $request->client_id,
            'lawyer_id' => $request->lawyer_id,
            'appointment_date' => $date,
            'start_time' => $time,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        Mail::to('cuongpham410vn@gmail.com')->send(new AppointmentNotification($appointment));

        return redirect()->route('admin.appointments.index')->with('success', 'Lịch hẹn đã được tạo thành công.');
    }

    public function edit($id)
    {
        $appointment = Appointments::findOrFail($id);
        $lawyers = User::where('role', 'lawyer')->get();
        return view('admin.appointments.edit', compact('appointment', 'lawyers'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'appointment_date' => 'required|date',
            'start_time' => 'required', // Đồng bộ tên
            'notes' => 'nullable|string',
        ]);

        $appointment = Appointments::findOrFail($id);

        // Đảm bảo dữ liệu gửi lên khớp với tên cột start_time trong DB
        $appointment->update([
            'appointment_date' => $request->appointment_date,
            'start_time' => $request->start_time,
            'notes' => $request->notes,
            'status' => $request->status ?? $appointment->status,
        ]);

        return redirect()->route('admin.appointments.index')->with('success', 'Cập nhật lịch hẹn thành công!');
    }

    public function destroy($id)
    {
        Appointments::findOrFail($id)->delete();
        return back()->with('success', 'Đã xóa lịch hẹn thành công.');
    }
}
