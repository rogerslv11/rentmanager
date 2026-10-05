<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('charges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('contract_id')->constrained()->cascadeOnDelete();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->string('reference', 32)->nullable();
            $table->string('description')->nullable();
            $table->decimal('rent_amount', 12, 2)->default(0);
            $table->decimal('condo_fee', 12, 2)->default(0);
            $table->decimal('property_tax', 12, 2)->default(0);
            $table->decimal('insurance_amount', 12, 2)->default(0);
            $table->decimal('late_fee', 12, 2)->default(0);
            $table->decimal('interest', 12, 2)->default(0);
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('other_amount', 12, 2)->default(0);
            $table->decimal('total_amount', 12, 2);
            $table->decimal('paid_amount', 12, 2)->default(0);
            $table->date('due_date');
            $table->date('paid_at')->nullable();
            $table->string('status', 32)->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['organization_id', 'status']);
            $table->index(['organization_id', 'due_date']);
            $table->index(['contract_id', 'status']);
            $table->index(['tenant_id', 'status']);
            $table->index('reference');
        });

        Schema::create('charge_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('charge_id')->constrained()->cascadeOnDelete();
            $table->string('description');
            $table->string('type', 32)->default('rent');
            $table->decimal('amount', 12, 2);
            $table->timestamps();

            $table->index('charge_id');
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('charge_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 12, 2);
            $table->date('paid_at');
            $table->string('method', 32);
            $table->string('transaction_id')->nullable();
            $table->string('receipt_path')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('received_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['organization_id', 'paid_at']);
            $table->index('charge_id');
            $table->index('method');
        });

        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('payment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('charge_id')->constrained()->cascadeOnDelete();
            $table->string('number', 32)->unique();
            $table->date('issued_at');
            $table->decimal('amount', 12, 2);
            $table->string('pdf_path')->nullable();
            $table->timestamps();

            $table->index(['organization_id', 'issued_at']);
        });

        Schema::create('owner_payouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('owner_id')->constrained()->cascadeOnDelete();
            $table->foreignId('contract_id')->nullable()->constrained()->nullOnDelete();
            $table->string('reference', 32)->nullable();
            $table->decimal('gross_amount', 12, 2);
            $table->decimal('admin_fee', 12, 2)->default(0);
            $table->decimal('maintenance_amount', 12, 2)->default(0);
            $table->decimal('other_deductions', 12, 2)->default(0);
            $table->decimal('net_amount', 12, 2);
            $table->date('period_start')->nullable();
            $table->date('period_end')->nullable();
            $table->date('paid_at')->nullable();
            $table->date('scheduled_for')->nullable();
            $table->string('status', 32)->default('pending');
            $table->string('payment_method', 32)->nullable();
            $table->string('transaction_id')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['organization_id', 'status']);
            $table->index(['owner_id', 'status']);
            $table->index('scheduled_for');
        });

        Schema::create('administration_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->string('name')->nullable();
            $table->decimal('percent', 5, 2)->default(8.00);
            $table->decimal('fixed_amount', 12, 2)->default(0);
            $table->string('applies_to', 32)->default('rent');
            $table->unsignedBigInteger('contract_id')->nullable();
            $table->unsignedBigInteger('property_id')->nullable();
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('organization_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('administration_fees');
        Schema::dropIfExists('owner_payouts');
        Schema::dropIfExists('receipts');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('charge_items');
        Schema::dropIfExists('charges');
    }
};
