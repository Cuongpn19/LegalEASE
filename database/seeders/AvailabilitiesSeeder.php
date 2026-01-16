<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AvailabilitiesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('availabilities')->truncate(); // 🔥 XOÁ SẠCH DATA
        $lawyerIds = [2, 3, 4, 5, 6, 7];

        $days = [
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday'
        ];

        $slots = [
            ['08:00:00', '09:00:00'],
            ['09:00:00', '10:00:00'],
            ['10:00:00', '11:00:00'],
            ['11:00:00', '12:00:00'],
            ['14:00:00', '15:00:00'],
            ['15:00:00', '16:00:00'],
            ['16:00:00', '17:00:00'],
            ['17:00:00', '18:00:00'],
        ];

        foreach ($lawyerIds as $lawyerId) {
            foreach ($days as $day) {
                foreach ($slots as $slot) {
                    DB::table('availabilities')->updateOrInsert(
                        [
                            'lawyer_id'   => $lawyerId,
                            'day_of_week' => $day,
                            'start_time'  => $slot[0],
                        ],
                        [
                            'end_time'   => $slot[1],
                            'status'     => 'available',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );
                }
            }
        }
    }
}
