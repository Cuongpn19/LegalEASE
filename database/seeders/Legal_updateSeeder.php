<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Legal_updates;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class Legal_updateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Legal_updates::create([
            'title' => 'The US attack on Venezuela through the lens of international law.',
            'content' => '(PLO) - The US launching a military campaign against Venezuela and arresting President Nicolas Maduro...',
            'image' => 'contents/VV5frWaAy8wvv0q7ZcF4daHqAT4uAjKqJBVkRQZ7.jpg',
            'author_id' => 1,
        ]);

         Legal_updates::create([
            'title' => 'The US attack on Venezuela through the lens of international law.',
            'content' => '(PLO) - The US launching a military campaign against Venezuela and arresting President Nicolas Maduro...',
            'image' => 'contents/VV5frWaAy8wvv0q7ZcF4daHqAT4uAjKqJBVkRQZ7.jpg',
            'author_id' => 1,
        ]);


        Legal_updates::create([
            'title' => 'The US attack on Venezuela through the lens of international law.',
            'content' => '(PLO) - The US launching a military campaign against Venezuela and arresting President Nicolas Maduro...',
            'image' => 'contents/VV5frWaAy8wvv0q7ZcF4daHqAT4uAjKqJBVkRQZ7.jpg',
            'author_id' => 2,
        ]);

        Legal_updates::create([
            'title' => 'Over 1.2 million visitors came to Ho Chi Minh City during the four-day New Year holiday',
            'content' => 'The Ho Chi Minh City Law Newspaper had an interview with Associate Professor Ngo Huu Phuoc, Deputy Head of the Faculty of Economic Law, University of Economics and Law (Vietnam National University Ho Chi Minh City)...',
            'image' => 'contents/UAsyaZGTdE5wlfhCFly69uhR0E4avRwGCusKQNhF.jpg',
            'author_id' => 3,
        ]);

        Legal_updates::create([
            'title' => 'Multiple-vehicle accident on Phan Thiet - Dau Giay Expressway',
            'content' => 'Analyzing the legal aspects of compensation for damages in the accident...',
            'image' => 'contents/uziiq5i7J9b5Ntfgf1wd2CC6yh7SBrG13XljaVql.jpg',
            'author_id' => 4,
        ]);

        Legal_updates::create([
            'title' => 'Proposing circumstances for dismissing leading and managerial officials in the courts.',
            'content' => 'The Supreme People Court has just issued a draft circular regulating the appointment, reappointment, resignation, dismissal, removal from office, temporary suspension, etc.',
            'image' => 'contents/phDtEsf38HcKU0oKxdSfSkGOPi2n4L3lktTD7nOc.jpg',
            'author_id' => 5,
        ]);

        Legal_updates::create([
            'title' => 'Russia-Ukraine conflict 4-1: High-intensity, fierce fighting in Donetsk and Zaporizhzhia.',
            'content' => '(PLO) - The Russia-Ukraine conflict escalated with over 190 clashes in a single day; both sides discussed casualties; President Zelensky declared that a peace agreement must include the military presence of Britain and France in Ukraine....',
            'image' => 'contents\z7396550106237_3c4212bfd886e8ea5551a728d516dcec.jpg',
            'author_id' => 2,
        ]);
    }
}
