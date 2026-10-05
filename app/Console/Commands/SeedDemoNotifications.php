<?php

namespace App\Console\Commands;

use App\Models\Charge;
use App\Models\Contract;
use App\Models\InsurancePolicy;
use App\Models\MaintenanceRequest;
use App\Models\Payment;
use App\Models\User;
use App\Notifications\ChargeOverdueNotification;
use App\Notifications\ContractExpiringNotification;
use App\Notifications\InsuranceExpiringNotification;
use App\Notifications\MaintenanceStatusNotification;
use App\Notifications\PaymentReceivedNotification;
use Illuminate\Console\Command;

class SeedDemoNotifications extends Command
{
    protected $signature = 'demo:notifications';

    protected $description = 'Create demo notifications for the current user';

    public function handle(): void
    {
        $user = User::first();
        if (! $user) {
            $this->error('No user found.');

            return;
        }

        $user->notifications()->delete();

        if ($payment = Payment::first()) {
            $user->notify(new PaymentReceivedNotification($payment));
        }
        if ($contract = Contract::first()) {
            $user->notify(new ContractExpiringNotification($contract, 15));
        }
        if ($maintenance = MaintenanceRequest::first()) {
            $user->notify(new MaintenanceStatusNotification($maintenance, 'Em Andamento'));
        }
        if ($insurance = InsurancePolicy::first()) {
            $user->notify(new InsuranceExpiringNotification($insurance, 30));
        }
        if ($charge = Charge::first()) {
            $user->notify(new ChargeOverdueNotification($charge, 5));
        }

        $this->info('Created '.$user->notifications()->count().' notifications');
    }
}
