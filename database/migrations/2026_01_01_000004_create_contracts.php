<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->foreignId('owner_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->string('number', 32)->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->date('signed_at')->nullable();
            $table->decimal('rent_amount', 12, 2);
            $table->decimal('condo_fee', 12, 2)->default(0);
            $table->decimal('property_tax', 12, 2)->default(0);
            $table->decimal('insurance_amount', 12, 2)->default(0);
            $table->unsignedTinyInteger('due_day')->default(5);
            $table->string('adjustment_index', 32)->default('IGPM');
            $table->string('adjustment_periodicity', 32)->default('yearly');
            $table->decimal('deposit_amount', 12, 2)->default(0);
            $table->decimal('late_fee_percent', 5, 2)->default(2.00);
            $table->decimal('interest_percent', 5, 2)->default(1.00);
            $table->decimal('admin_fee_percent', 5, 2)->default(8.00);
            $table->decimal('admin_fee_fixed', 12, 2)->default(0);
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->boolean('auto_renew')->default(false);
            $table->string('status', 32)->default('draft');
            $table->text('notes')->nullable();
            $table->text('terms')->nullable();
            $table->date('terminated_at')->nullable();
            $table->string('termination_reason')->nullable();
            $table->unsignedBigInteger('parent_contract_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['organization_id', 'status']);
            $table->index(['tenant_id', 'status']);
            $table->index(['property_id', 'status']);
            $table->index('end_date');
        });

        Schema::create('contract_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('path');
            $table->string('mime_type', 128)->nullable();
            $table->unsignedBigInteger('size')->nullable();
            $table->unsignedInteger('version')->default(1);
            $table->timestamps();
        });

        Schema::create('contract_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('action', 64);
            $table->json('changes')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contract_histories');
        Schema::dropIfExists('contract_documents');
        Schema::dropIfExists('contracts');
    }
};
