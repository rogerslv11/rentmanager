<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('company_name')->nullable();
            $table->string('tax_id', 32)->nullable()->index();
            $table->string('email')->nullable();
            $table->string('phone', 32)->nullable();
            $table->string('category', 64)->nullable();
            $table->string('specialty', 128)->nullable();
            $table->decimal('hourly_rate', 12, 2)->nullable();
            $table->text('address')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('organization_id');
            $table->index('category');
        });

        Schema::create('maintenance_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tenant_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('vendor_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->text('description');
            $table->string('category', 64)->nullable();
            $table->string('priority', 32)->default('medium');
            $table->string('status', 32)->default('requested');
            $table->date('scheduled_for')->nullable();
            $table->date('started_at')->nullable();
            $table->date('completed_at')->nullable();
            $table->decimal('estimated_cost', 12, 2)->nullable();
            $table->decimal('final_cost', 12, 2)->nullable();
            $table->text('resolution_notes')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['organization_id', 'status']);
            $table->index(['organization_id', 'priority']);
            $table->index(['property_id', 'status']);
        });

        Schema::create('maintenance_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maintenance_request_id')->constrained()->cascadeOnDelete();
            $table->string('description');
            $table->decimal('quantity', 10, 2)->default(1);
            $table->decimal('unit_cost', 12, 2)->default(0);
            $table->decimal('total_cost', 12, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('maintenance_quotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maintenance_request_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vendor_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 12, 2);
            $table->text('description')->nullable();
            $table->string('status', 32)->default('pending');
            $table->date('valid_until')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('maintenance_request_id');
            $table->index('vendor_id');
        });

        Schema::create('maintenance_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maintenance_request_id')->constrained()->cascadeOnDelete();
            $table->string('path');
            $table->string('caption')->nullable();
            $table->string('stage', 32)->default('before');
            $table->timestamps();

            $table->index('maintenance_request_id');
        });

        Schema::create('inspections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->foreignId('contract_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('tenant_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('inspector_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('type', 32);
            $table->string('title')->nullable();
            $table->date('scheduled_for');
            $table->date('completed_at')->nullable();
            $table->text('notes')->nullable();
            $table->text('summary')->nullable();
            $table->json('checklist')->nullable();
            $table->string('status', 32)->default('scheduled');
            $table->timestamps();

            $table->index(['organization_id', 'type']);
            $table->index(['property_id', 'scheduled_for']);
        });

        Schema::create('inspection_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspection_id')->constrained()->cascadeOnDelete();
            $table->string('room');
            $table->string('item');
            $table->string('condition', 32)->default('good');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('inspection_id');
        });

        Schema::create('inspection_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspection_id')->constrained()->cascadeOnDelete();
            $table->string('path');
            $table->string('caption')->nullable();
            $table->timestamps();
        });

        Schema::create('insurance_policies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->foreignId('contract_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type', 32);
            $table->string('provider', 128);
            $table->string('policy_number', 64);
            $table->decimal('coverage_amount', 14, 2)->nullable();
            $table->decimal('premium_amount', 12, 2)->default(0);
            $table->date('start_date');
            $table->date('end_date');
            $table->string('document_path')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['organization_id', 'type']);
            $table->index(['property_id', 'end_date']);
        });

        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('property_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('owner_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('contract_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('maintenance_request_id')->nullable()->constrained()->nullOnDelete();
            $table->string('category', 64);
            $table->string('description');
            $table->decimal('amount', 12, 2);
            $table->date('expense_date');
            $table->string('vendor_name')->nullable();
            $table->string('document_path')->nullable();
            $table->string('status', 32)->default('paid');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['organization_id', 'category']);
            $table->index(['organization_id', 'expense_date']);
            $table->index('property_id');
            $table->index('owner_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('insurance_policies');
        Schema::dropIfExists('inspection_photos');
        Schema::dropIfExists('inspection_items');
        Schema::dropIfExists('inspections');
        Schema::dropIfExists('maintenance_photos');
        Schema::dropIfExists('maintenance_quotes');
        Schema::dropIfExists('maintenance_items');
        Schema::dropIfExists('maintenance_requests');
        Schema::dropIfExists('vendors');
    }
};
