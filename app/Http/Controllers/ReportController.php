<?php

namespace App\Http\Controllers;

use App\Exports\AppointmentsFullExport;
use App\Exports\LawyersActivityExport;
use App\Models\Appointments;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(){
        // 1. Thống kê tổng quan lịch hẹn
        $appointmentStats = [
            'total'     => Appointments::count(),
            'completed' =>Appointments::where('status', 'completed')->count(),
            'pending'   => Appointments::where('status', 'pending')->count(),
            'confirmed' => Appointments::where('status', 'confirmed')->count(),
            'cancelled' => Appointments::where('status', 'cancelled')->count(),
        ];

        // 2. Thống kê hoạt động của Luật sư (Số lịch hẹn mỗi người nhận)
        $lawyerPerformance = User::where('role', 'lawyer')
            ->withCount('appointments')
            ->orderBy('appointments_count', 'desc')
            ->take(10)
            ->get();

        // 3. Lấy phản hồi khách hàng chi tiết (Nếu bạn có trường feedback trong table)
        $recentFeedbacks = Appointments::whereNotNull('feedback')
            ->with(['client', 'lawyer'])
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.reports.index', compact('appointmentStats', 'lawyerPerformance', 'recentFeedbacks'));
    }

    public function exportAppointments()
    {
        // Logic xuất file Excel hoặc PDF tại đây
        return Excel::download(new AppointmentsFullExport, 'danh-sach-lich-hen.xlsx');
    }

    public function exportLawyers()
    {
        return Excel::download(new LawyersActivityExport, 'hoat-dong-luat-su.xlsx');
    }

}
