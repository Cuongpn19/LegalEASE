<?php

namespace Database\Seeders;

use App\Models\Client_profiles;
use App\Models\Lawyer_profiles;
use App\Models\Specialization;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $spec1 = Specialization::create(['name' => 'Criminal Law']);
        $spec2 = Specialization::create(['name' => 'Civil Law']);
        $spec3 = Specialization::create(['name' => 'Business Law']);
        $spec4 = Specialization::create(['name' => 'Employment Law']);
        $spec5 = Specialization::create(['name' => 'Land Law']);
        $spec6 = Specialization::create(['name' => 'Tax Law']);
        // 1. Tạo tài khoản Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@legalease.com',
            'password' => Hash::make('123456'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        // 2. Tạo 3 Luật sư mẫu
        $lawyer1 = User::create([
            'name' => 'Nguyen Van Luat',
            'email' => 'luatsu1@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'lawyer',
            'status' => 'active',
        ]);
        Lawyer_profiles::create([
            'user_id' => $lawyer1->id,
            'specialization' => 'Criminal Law',
            'bio' => 'I have over 10 years of experience in the field',
            'location' => 'Ha Noi',
            'experience_years' => 10,
            'is_verified' => true,
            'rating' => 4.8,
        ]);
        $lawyer1->specializations()->attach([$spec1->id, $spec3->id]);

        $lawyer2 = User::create([
            'name' => 'Tran Thi Phap',
            'email' => 'luatsu2@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'lawyer',
            'status' => 'pending', // Trạng thái chờ duyệt để test giao diện
        ]);
        Lawyer_profiles::create([
            'user_id' => $lawyer2->id,
            'specialization' => 'Civil Law',
            'bio' => 'I have over 5 years of experience in the field',
            'location' => 'Ho Chi Minh',
            'experience_years' => 5,
            'is_verified' => false,
            'rating' => 4.5,
        ]);
        $lawyer2->specializations()->attach([$spec2->id]);

        $lawyer3 = User::create([
            'name' => 'Le Van Phap',
            'email' => 'luatsu3@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'lawyer',
            'status' => 'active', // Trạng thái chờ duyệt để test giao diện
        ]);
        Lawyer_profiles::create([
            'user_id' => $lawyer3->id,
            'specialization' => 'Business Law',
            'bio' => 'I have over 7 years of experience in the field',
            'location' => 'Hai Phong',
            'experience_years' => 7,
            'is_verified' => true,
            'rating' => 4.7,
        ]);
        $lawyer3->specializations()->attach([$spec3->id]);

        $lawyer4 = User::create([
            'name' => 'Pham Thi Cong',
            'email' => 'luatsu4@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'lawyer',
            'status' => 'pending', // Trạng thái chờ duyệt để test giao diện
        ]);
        Lawyer_profiles::create([
            'user_id' => $lawyer4->id,
            'specialization' => 'Employment Law',
            'bio' => 'I have over 8 years of experience in the field',
            'location' => 'Da Nang',
            'experience_years' => 8,
            'is_verified' => false,
            'rating' => 4.6,
        ]);
        $lawyer4->specializations()->attach([$spec1->id, $spec4->id]);

        $lawyer5 = User::create([
            'name' => 'Nguyen Van C',
            'email' => 'nguyenvanc@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'lawyer',
            'status' => 'pending', // Trạng thái chờ duyệt để test giao diện
        ]);
        Lawyer_profiles::create([
            'user_id' => $lawyer5->id,
            'specialization' => 'Land Law',
            'bio' => 'I have over 8 years of experience in the field',
            'location' => 'Nha Trang',
            'experience_years' => 8,
            'is_verified' => false,
            'rating' => 4.6,
        ]);
        $lawyer5->specializations()->attach([$spec5->id]);

         $lawyer6 = User::create([
            'name' => 'Nguyen Van D',
            'email' => 'nguyenvand@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'lawyer',
            'status' => 'pending', // Trạng thái chờ duyệt để test giao diện
        ]);
        Lawyer_profiles::create([
            'user_id' => $lawyer6->id,
            'specialization' => 'Tax Law',
            'bio' => 'I have over 8 years of experience in the field',
            'location' => 'Da Nang',
            'experience_years' => 8,
            'is_verified' => false,
            'rating' => 4.6,
        ]);
        $lawyer6->specializations()->attach([$spec6->id]);

        // 3. Tạo 2 Khách hàng mẫu
        $client1 = User::create([
            'name' => 'Le Van Khach',
            'email' => 'khachhang@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'client',
            'status' => 'active',
        ]);
        Client_profiles::create([
            'name' => 'Le Van Khach',
            'user_id' => $client1->id,
            'phone_number' => '0987654321',
            'address' => 'Da Nang'
        ]);

        $client2 = User::create([
            'name' => 'Tran Thi Nguoi',
            'email' => 'khachhang2@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'client',
            'status' => 'active',
        ]);
        Client_profiles::create([
            'name' => 'Tran Thi Nguoi',
            'user_id' => $client2->id,
            'phone_number' => '0987654322',
            'address' => 'Ha Noi'
        ]);

        $client3 = User::create([
            'name' => 'Pham Van Khach',
            'email' => 'khachhang3@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'client',
            'status' => 'active',
        ]);
        Client_profiles::create([
            'name' => 'Pham Van Khach',
            'user_id' => $client3->id,
            'phone_number' => '0987654323',
            'address' => 'Ho Chi Minh'
        ]);
    }
}
