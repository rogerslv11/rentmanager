<?php

use App\Jobs\CheckExpiringContracts;
use App\Jobs\CheckExpiringInsurance;
use App\Jobs\GenerateMonthlyChargesJob;
use App\Jobs\MarkOverdueChargesJob;
use App\Jobs\SendOverdueChargeNotifications;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Cobranças mensais (dia 1 de cada mês às 03:00)
Schedule::job(new GenerateMonthlyChargesJob)->monthlyOn(1, '03:00')->name('generate-monthly-charges');

// Atualizar status de cobranças vencidas (diariamente)
Schedule::job(new MarkOverdueChargesJob)->dailyAt('00:05')->name('mark-overdue-charges');

// Enviar notificações de cobranças em atraso (diário 09:00)
Schedule::job(new SendOverdueChargeNotifications)->dailyAt('09:00')->name('send-overdue-notifications');

// Verificar contratos próximos do vencimento (diário 08:00)
Schedule::job(new CheckExpiringContracts)->dailyAt('08:00')->name('check-expiring-contracts');

// Verificar seguros vencendo (semanal)
Schedule::job(new CheckExpiringInsurance)->weekly()->mondays()->at('08:00')->name('check-expiring-insurance');
