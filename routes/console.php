<?php
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\NotifyParticipants;
use App\Console\Commands\NotifyEventCreators;

// Comando padrão de inspiração
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

//php artisan notify-participants

Artisan::command('app:notify-participants', function () {
    app(NotifyParticipants::class)->handle();
})->purpose('Notify participants about upcoming events')->weeklyOn(1, '08:00');

//php app:notify-event-creators
Artisan::command('app:notify-event-creators', function () {
    app(NotifyEventCreators::class)->handle();
})->purpose('Notify participants about upcoming events')->weeklyOn(1, '08:00');
