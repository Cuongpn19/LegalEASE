<?php

namespace Database\Seeders;

use App\Models\Appointments;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppointmentFeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy 10 lịch hẹn đã hoàn thành (confirmed) để thêm phản hồi mẫu
        $appointments = Appointments::where('status', 'confirmed')->take(10)->get();

        $feedbacks = [
            'The lawyer provided very helpful advice and resolved the issue quickly and efficiently.',
            'Very satisfied with the service; the office was professional.',
            'The lawyer expertise was very deep; I was able to resolve the',
            'The procedure was quick and the prices were reasonable.',
            'Thank you, lawyer, for your support in the recent lawsuit.'
        ];

        foreach ($appointments as $appointment) {
            $appointment->update([
                'feedback' => $feedbacks[array_rand($feedbacks)]
            ]);
        }
    }
}
