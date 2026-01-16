<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointments;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LawyerStatsController extends Controller
{
    public function dashboard(){
      /** @var \App\Models\User $user */
    $user = Auth::user();
    $lawyerId = $user->id; // Hoặc $user->lawyerProfile->id tùy cấu hình DB của bạn

    // Lấy ngày hôm nay (Carbon)
    $today = now();

    // 1. Đếm số lịch hẹn riêng trong ngày hôm nay của luật sư này
    $todayCount = Appointments::where('lawyer_id', $lawyerId)
        ->whereDate('appointment_date', $today->toDateString())
        ->count();

    // 2. Các thông số khác cho card thống kê
    $pending = Appointments::where('lawyer_id', $lawyerId)->where('status', 'pending')->count();
    $confirmed = Appointments::where('lawyer_id', $lawyerId)->where('status', 'confirmed')->count();
    $completed = Appointments::where('lawyer_id', $lawyerId)->where('status', 'completed')->count();

    // 3. Lấy danh sách lịch hẹn để truyền vào JS cho Calendar
  $appointments = Appointments::where('lawyer_id', $lawyerId)
    ->with('client:id,name')
    ->select('id', 'appointment_date', 'start_time', 'client_id', 'status')
    ->get()
    ->toArray();

    $today = now();
    $todayCount = Appointments::where('lawyer_id', $lawyerId)
        ->whereDate('appointment_date', $today->toDateString())
        ->count();
    $name = $user;
    $pending = Appointments::where('lawyer_id', $lawyerId)->where('status', 'pending')->count();
    $confirmed = Appointments::where('lawyer_id', $lawyerId)->where('status', 'confirmed')->count();
    $completed = Appointments::where('lawyer_id', $lawyerId)->where('status', 'completed')->count();

    return view('lawyer.dashboard', compact('appointments','today','todayCount','name','pending', 'confirmed', 'completed'));
    }
}
