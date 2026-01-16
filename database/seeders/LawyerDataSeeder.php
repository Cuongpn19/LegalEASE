<?php

namespace Database\Seeders;

use App\Models\Appointments;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LawyerDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Tạo tài khoản Luật sư mẫu (ID = 2)
        $lawyer = \App\Models\User::updateOrCreate(
            ['id' => 2],
            [
                'name' => 'Nguyen Van Luat',
                'email' => 'lawyer@example.com',
                'password' => bcrypt('password'),
                'role' => 'lawyer'
            ]
        );

        // 2. Tạo tài khoản Khách hàng mẫu (ID = 7) để tránh lỗi Foreign Key
        $client = \App\Models\User::updateOrCreate(
            ['id' => 7],
            [
                'name' => 'Test',
                'email' => 'client@example.com',
                'password' => bcrypt('password'),
                'role' => 'client'
            ]
        );

        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        // 3. Tạo khung giờ rảnh gốc cho Luật sư
        foreach ($days as $day) {
            \App\Models\Availabilities::updateOrCreate(
                [
                    'lawyer_id' => $lawyer->id,
                    'day_of_week' => $day,
                    'start_time' => '10:00:00'
                ],
                [
                    'end_time' => '11:00:00',
                    'status' => 'available'
                ]
            );
        }

        // 4. Tạo lịch đã đặt để test chữ "Đã hết" trên giao diện
        \App\Models\Appointments::create([
            'lawyer_id' => $lawyer->id,
            'client_id' => $client->id, // Sử dụng ID của khách hàng vừa tạo ở trên
            'appointment_date' => \Carbon\Carbon::parse('next monday')->toDateString(),
            'start_time' => '10:00:00',
            'status' => 'pending',
            'notes' => 'This calendar will show as over'
        ]);
    }
}
