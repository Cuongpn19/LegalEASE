<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Chạy lệnh này mỗi ngày vào lúc nửa đêm (00:00)
Schedule::command('app:auto-cancel-appointments')->daily();