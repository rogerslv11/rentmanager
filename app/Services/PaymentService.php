<?php

namespace App\Services;

use App\Models\Charge;
use App\Models\Payment;
use App\Models\Receipt;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    public function recordPayment(Charge $charge, array $data): Payment
    {
        return DB::transaction(function () use ($charge, $data) {
            $payment = Payment::create([
                'organization_id' => $charge->organization_id,
                'charge_id' => $charge->id,
                'amount' => $data['amount'],
                'paid_at' => $data['paid_at'] ?? now(),
                'method' => $data['method'],
                'transaction_id' => $data['transaction_id'] ?? null,
                'receipt_path' => $data['receipt_path'] ?? null,
                'notes' => $data['notes'] ?? null,
                'received_by' => auth()->id(),
            ]);

            $charge->paid_amount = (float) $charge->paid_amount + (float) $data['amount'];
            $charge->refreshStatus();

            Receipt::create([
                'organization_id' => $charge->organization_id,
                'payment_id' => $payment->id,
                'charge_id' => $charge->id,
                'issued_at' => now(),
                'amount' => $payment->amount,
            ]);

            return $payment;
        });
    }
}
