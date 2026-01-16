<?php

namespace Database\Seeders;

use App\Models\Specialization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'Criminal Law'],
            ['name' => 'Civil Law'],
            ['name' => 'Land Law'],
            ['name' => 'Marriage and Family Law'],
            ['name' => 'Business Law'],
            ['name' => 'Employment Law'],
            ['name' => 'Intellectual Property Law'],
            ['name' => 'Tax Law'],
        ];

        foreach ($data as $item) {
            Specialization::updateOrCreate(['name' => $item['name']], $item);
        }
    }
}
