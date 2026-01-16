<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LawyerProfilesController;
use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AvailabilitiesController;
use App\Http\Controllers\ClientProfilesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LegalUpdatesController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Client\AppointmentforlawyerController;
use App\Http\Controllers\LawyerStatsController;
use App\Http\Controllers\BlogController;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

// web.php
Route::get('/blog/{id}', [HomeController::class, 'show'])
    ->name('blog.show');

/* Auth */
Route::get('/register', [AuthController::class, 'create'])->name('register');
Route::post('/register', [AuthController::class, 'store']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Hiển thị form nhập email
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
// Xử lý gửi link reset
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
// Hiển thị form nhập mật khẩu mới
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
// Lưu mật khẩu mới
Route::post('/reset-password', [AuthController::class, 'updatePassword'])->name('password.update');

Route::middleware(['auth', 'PreventBackHistory'])->group(function () {
    Route::get('/client/dashboard', function () { return "Trang khách hàng"; })
        ->name('client.dashboard');

    Route::get('/lawyer/dashboard', function () { return "Trang luật sư"; })
        ->name('lawyer.dashboard');

    Route::get('/dashboard', [AdminController::class, 'dashboard'])
        ->name('dashboard');

     Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::put('/settings/update', [AdminController::class, 'updateSettings'])->name('settings.update');

    Route::get('/booking', [AppointmentsController::class, 'publicCreate'])
        ->name('appointments.public.create');

    Route::post('/booking', [AppointmentsController::class, 'publicStore'])
        ->name('appointments.public.store');

    Route::post('/admin/availabilities/store', [AvailabilitiesController::class, 'store'])
        ->name('admin.availabilities.store');

    Route::get('/admin/availabilities/{id}/edit', [AvailabilitiesController::class, 'edit'])
        ->name('admin.availabilities.edit');
    Route::put('/admin/availabilities/{id}', [AvailabilitiesController::class, 'update'])
        ->name('admin.availabilities.update');

    Route::delete('/admin/availabilities/{id}', [AvailabilitiesController::class, 'destroy'])
        ->name('admin.availabilities.destroy');

    /* Appointments */
    Route::get('/booking', [AppointmentsController::class, 'publicCreate'])
        ->name('appointments.public.create');

    Route::post('/booking', [AppointmentsController::class, 'publicStore'])
        ->name('appointments.public.store');

    Route::patch('/appointments/{id}/status',
        [AppointmentsController::class, 'updateStatus'])
        ->name('appointments.updateStatus');

    Route::resource('appointments', AppointmentsController::class);

    /* Users */
    Route::get('/users', [AdminController::class, 'manageUsers'])
        ->name('users.index');

    Route::post('/users/{id}/approve',
        [AdminController::class, 'approveLawyer'])
        ->name('lawyers.approve');

    Route::post('/users/{id}/toggle-status',
        [AdminController::class, 'toggleStatus'])
        ->name('users.toggleStatus');

    Route::post('/users/{id}/revert',
        [AdminController::class, 'revertPending'])
        ->name('users.revertPending');

    /* Reports */
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/export-lawyers', [ReportController::class, 'exportLawyers'])->name('export.lawyers');
        Route::get('/export-appointments', [ReportController::class, 'exportAppointments'])->name('export.appointments');
        Route::get('/export-feedback', [ReportController::class, 'exportFeedback'])->name('export.feedback');
    });

    Route::resource('lawyers', LawyerProfilesController::class);
    Route::resource('clients', ClientProfilesController::class);
    Route::resource('contents', LegalUpdatesController::class);


    Route::get('/dashboard', [ClientProfilesController::class, 'dashboard'])->name('dashboard');
    Route::get('/lawyers', [ClientProfilesController::class, 'findLawyer'])->name('lawyers.index');
    Route::get('/lawyers/{id}/book', [ClientProfilesController::class, 'showBookingForm'])->name('lawyers.book');
    Route::post('/lawyers/book', [ClientProfilesController::class, 'storeBooking'])->name('lawyers.storeBooking');
    Route::get('/my-appointments', [ClientProfilesController::class, 'myAppointments'])->name('appointments.index');
    Route::patch('/appointments/{id}/cancel', [ClientProfilesController::class, 'cancelAppointment'])->name('appointments.cancel');
    Route::post('/appointments/{id}/review', [ClientProfilesController::class, 'storeReview'])->name('reviews.store');
    // My Profile
    Route::get('/profile', [ClientProfilesController::class, 'myProfile'])->name('profile');
    Route::post('/profile/update', [ClientProfilesController::class, 'updateProfile'])->name('profile.update');

    // Settings
    Route::get('/settings', [ClientProfilesController::class, 'settings'])->name('settings');
    Route::post('/settings/password', [ClientProfilesController::class, 'updatePassword'])->name('settings.password');
});

/* Admin Routes */
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::put('/settings/update', [AdminController::class, 'updateSettings'])->name('settings.update');

     Route::get('/lawyers/{id}/edit', [AdminController::class, 'edit'])
        ->name('lawyers.edit');

    Route::put('/lawyers/{id}', [AdminController::class, 'update'])
        ->name('lawyers.update');

    Route::get('/dashboard', [AdminController::class, 'dashboard'])
        ->name('dashboard');

    Route::get('/booking', [AppointmentsController::class, 'publicCreate'])
        ->name('appointments.public.create');

    Route::post('/booking', [AppointmentsController::class, 'publicStore'])
        ->name('appointments.public.store');

    /* Appointments */
    Route::get('/booking', [AppointmentsController::class, 'publicCreate'])
        ->name('appointments.public.create');

    Route::post('/booking', [AppointmentsController::class, 'publicStore'])
        ->name('appointments.public.store');

    Route::patch('/appointments/{id}/status',
        [AppointmentsController::class, 'updateStatus'])
        ->name('appointments.updateStatus');

    Route::resource('appointments', AppointmentsController::class);
    // Route::post('/appointments/book', [AppointmentsController::class, 'storeAppointment'])
    //     ->name('appointments.store')->middleware(['auth', 'PreventBackHistory']);


    Route::get('/my-availabilities', [AvailabilitiesController::class, 'index'])->name('availabilities.index');
    Route::post('/my-availabilities', [AvailabilitiesController::class, 'store'])->name('availabilities.store');
    Route::delete('/my-availabilities/{id}', [AvailabilitiesController::class, 'destroy'])->name('availabilities.destroy');



    /* Users */
    Route::get('/users', [AdminController::class, 'manageUsers'])
        ->name('users.index');

    Route::post('/users/{id}/approve',
        [AdminController::class, 'approveLawyer'])
        ->name('lawyers.approve');

    Route::post('/users/{id}/toggle-status',
        [AdminController::class, 'toggleStatus'])
        ->name('users.toggleStatus');

    Route::post('/users/{id}/revert',
        [AdminController::class, 'revertPending'])
        ->name('users.revertPending');

    /* Reports */
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/export-lawyers', [ReportController::class, 'exportLawyers'])->name('export.lawyers');
        Route::get('/export-appointments', [ReportController::class, 'exportAppointments'])->name('export.appointments');
        Route::get('/export-feedback', [ReportController::class, 'exportFeedback'])->name('export.feedback');
    });

    Route::resource('lawyers', LawyerProfilesController::class);
    Route::resource('clients', ClientProfilesController::class);
    Route::resource('contents', LegalUpdatesController::class);

});

Route::middleware(['auth', 'role:lawyer'])
    ->prefix('lawyer')
    ->name('lawyer.')
    ->group(function(){
        //Xem lịch hẹn appointment [penging, confirmed, completed]
        Route::get('/pendingappointment', [LawyerProfilesController::class, 'pendingList'])
        ->name('pendingList');
        Route::get('/confirmedappointment', [LawyerProfilesController::class, 'confirmedList'])
        ->name('confirmedList');
        Route::get('/completedappointment', [LawyerProfilesController::class, 'completedList'])
        ->name('completedList');
        //Chức năng cho Appointment
        Route::post('/accept', [AppointmentforlawyerController::class, 'accept'])
        ->name('accept');
        Route::post('/decline', [AppointmentforlawyerController::class, 'decline'])
        ->name('decline');
        Route::post('/done', [AppointmentforlawyerController::class, 'done'])
        ->name('done');
        //Xem hồ sơ
            //Hiển thị Dashboard
            Route::get('/dashboard', [LawyerStatsController::class, 'dashboard'])
            ->name('dashboard');
            //Hiển thị hồ sơ
            Route::get('/profile', [LawyerProfilesController::class, 'profile'])
            ->name('profile');
                //Cập nhật hồ sơ
                Route::get('edit', [LawyerProfilesController::class, 'edit'])
                ->name('edit');
                Route::put('update', [LawyerProfilesController::class, 'update'])
                ->name('update');
            //Hiển thị câu hỏi
            Route::get('/question', [LawyerProfilesController::class, 'question'])
            ->name('question');
            //Trả lời câu hỏi
            Route::post('answer', [LawyerProfilesController::class, 'answer'])
            ->name('answer');
            Route::put('/reanswer/{id}', [LawyerProfilesController::class, 'reanswer'])
            ->name('reanswer');
            // //Hiển thị Blog
            Route::get('/blog', [BlogController::class, 'index'])
            ->name('blog');

           // ai cũng xem được blog
            // Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');

            // chỉ luật sư mới đăng bài
            Route::get('/blogs/create', [BlogController::class, 'create'])->name('blogs.create');
            Route::post('/blogs', [BlogController::class, 'store'])->name('blogs.store');

    });

    Route::middleware(['auth', 'role:client'])
    ->prefix('client')
    ->name('client.')
    ->group(function(){
        //Trang giao diện hỏi của Client
        Route::get('/question/{id}', [AppointmentforlawyerController::class, 'question'])
        ->name('question');
        Route::post('/store', [AppointmentforlawyerController::class, 'storequestion'])
        ->name('storequestion');
        Route::get('/blog', [BlogController::class, 'index'])
            ->name('blog');
        Route::get('/dashboard', [ClientProfilesController::class, 'dashboard'])->name('dashboard');
    Route::get('/lawyers', [ClientProfilesController::class, 'findLawyer'])->name('lawyers.index');
    Route::get('/check-availability', [ClientProfilesController::class, 'checkAvailability'])->name('lawyers.checkAvailability');
    Route::get('/lawyers/{id}/book', [ClientProfilesController::class, 'showBookingForm'])->name('lawyers.book');
    Route::post('/lawyers/book', [ClientProfilesController::class, 'storeBooking'])->name('lawyers.storeBooking');
    Route::get('/my-appointments', [ClientProfilesController::class, 'myAppointments'])->name('appointments.index');
    Route::patch('/appointments/{id}/cancel', [ClientProfilesController::class, 'cancelAppointment'])->name('appointments.cancel');
    Route::post('/appointments/{id}/review', [ClientProfilesController::class, 'storeReview'])->name('reviews.store');
    // My Profile
    Route::get('/profile', [ClientProfilesController::class, 'myProfile'])->name('profile');
    Route::post('/profile/update', [ClientProfilesController::class, 'updateProfile'])->name('profile.update');

    // Settings
    Route::get('/settings', [ClientProfilesController::class, 'settings'])->name('settings');
    Route::post('/settings/password', [ClientProfilesController::class, 'updatePassword'])->name('settings.password');
    });


