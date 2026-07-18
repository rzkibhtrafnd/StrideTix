<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Services\OrderService;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function (OrderService $orderService) {
    $orderService->releaseExpiredOrders();
})->everyMinute()->name('release-expired-orders')->withoutOverlapping();