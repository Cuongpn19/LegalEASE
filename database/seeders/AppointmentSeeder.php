<?php

namespace Database\Seeders;

use App\Models\Appointments;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Appointments::create([
        'client_id' => 6, // ID của khách hàng trong bảng users
        'lawyer_id' => 2, // ID của luật sư trong bảng users
        'appointment_date' => now()->addDays(2),
        'start_time' => '10:00:00',
        'status' => 'pending',
        'notes' => 'Initial consultation regarding contract review.',
    ]);

        Appointments::create([
        'client_id' => 7, // ID của khách hàng trong bảng users
        'lawyer_id' => 2, // ID của luật sư trong bảng users
        'appointment_date' => now()->addDays(5),
        'start_time' => '14:00:00',
        'status' => 'confirmed',
        'notes' => 'Follow-up meeting to discuss case strategy.',
    ]);

        Appointments::create([
        'client_id' => 8, // ID của khách hàng trong bảng users
        'lawyer_id' => 3, // ID của luật sư trong bảng users
        'appointment_date' => now()->addDays(3),
        'start_time' => '09:00:00',
        'status' => 'completed',
        'notes' => 'Case closed successfully.',
    ]);

        Appointments::create([
        'client_id' => 6, // ID của khách hàng trong bảng users
        'lawyer_id' => 3, // ID của luật sư trong bảng users
        'appointment_date' => now()->addDays(7),
        'start_time' => '11:00:00',
        'status' => 'cancelled',
        'notes' => 'Client cancelled due to personal reasons.',
    ]);

        Appointments::create([
        'client_id' => 7, // ID của khách hàng trong bảng users
        'lawyer_id' => 4, // ID của luật sư trong bảng users
        'appointment_date' => now()->addDays(1),
        'start_time' => '15:00:00',
        'status' => 'pending',
        'notes' => 'Discussion on legal options for business setup.',
    ]);

    }
}
