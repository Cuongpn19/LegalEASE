<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointments;
use Carbon\Carbon;

class AutoCancelAppointments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:auto-cancel-appointments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Tìm các lịch hẹn:
        // 1. Có trạng thái là 'pending'
        // 2. Có ngày hẹn (appointment_date) nhỏ hơn ngày hôm nay
        $affectedRows = Appointments::whereIn('status', ['pending', 'confirmed'])
            ->whereDate('appointment_date', '<', Carbon::today())
            ->update(['status' => 'cancelled']);

        $this->info("Đã tự động hủy $affectedRows lịch hẹn quá hạn.");
    }
}
