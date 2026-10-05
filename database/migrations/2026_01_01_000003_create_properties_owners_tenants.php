<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('owners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('tax_id', 32)->nullable()->index();
            $table->string('email')->nullable();
            $table->string('phone', 32)->nullable();
            $table->string('mobile', 32)->nullable();
            $table->text('address')->nullable();
            $table->string('city', 128)->nullable();
            $table->string('state', 64)->nullable();
            $table->string('zip_code', 16)->nullable();
            $table->string('bank_name', 128)->nullable();
            $table->string('bank_agency', 32)->nullable();
            $table->string('bank_account', 32)->nullable();
            $table->string('bank_account_type', 32)->nullable();
            $table->string('pix_key')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('organization_id');
            $table->index('name');
        });

        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('tax_id', 32)->nullable()->index();
            $table->string('email')->nullable();
            $table->string('phone', 32)->nullable();
            $table->string('mobile', 32)->nullable();
            $table->date('birth_date')->nullable();
            $table->string('nationality', 64)->nullable();
            $table->string('marital_status', 32)->nullable();
            $table->string('profession', 128)->nullable();
            $table->decimal('monthly_income', 12, 2)->nullable();
            $table->text('address')->nullable();
            $table->string('city', 128)->nullable();
            $table->string('state', 64)->nullable();
            $table->string('zip_code', 16)->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone', 32)->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('organization_id');
            $table->index('user_id');
            $table->index('name');
        });

        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('owner_id')->nullable()->constrained()->nullOnDelete();
            $table->string('code', 32)->nullable();
            $table->string('slug')->nullable();
            $table->string('name');
            $table->string('type', 64);
            $table->text('description')->nullable();
            $table->decimal('area_total', 10, 2)->nullable();
            $table->decimal('area_built', 10, 2)->nullable();
            $table->unsignedTinyInteger('bedrooms')->default(0);
            $table->unsignedTinyInteger('bathrooms')->default(0);
            $table->unsignedTinyInteger('parking_spaces')->default(0);
            $table->unsignedTinyInteger('floor')->nullable();
            $table->string('address')->nullable();
            $table->string('address_number', 32)->nullable();
            $table->string('address_complement')->nullable();
            $table->string('neighborhood', 128)->nullable();
            $table->string('city', 128)->nullable();
            $table->string('state', 64)->nullable();
            $table->string('zip_code', 16)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->decimal('rent_amount', 12, 2)->default(0);
            $table->decimal('condo_fee', 12, 2)->default(0);
            $table->decimal('property_tax', 12, 2)->default(0);
            $table->decimal('insurance_amount', 12, 2)->default(0);
            $table->string('status', 32)->default('available');
            $table->boolean('is_furnished')->default(false);
            $table->boolean('is_published')->default(false);
            $table->boolean('pets_allowed')->default(false);
            $table->json('features')->nullable();
            $table->json('settings')->nullable();
            $table->date('acquisition_date')->nullable();
            $table->decimal('acquisition_value', 14, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['organization_id', 'slug']);
            $table->index(['organization_id', 'status']);
            $table->index(['organization_id', 'type']);
            $table->index('owner_id');
        });

        Schema::create('property_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->string('path');
            $table->string('caption')->nullable();
            $table->boolean('is_cover')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index('property_id');
        });

        Schema::create('owner_property', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained()->cascadeOnDelete();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->decimal('ownership_percent', 5, 2)->default(100);
            $table->timestamps();

            $table->unique(['owner_id', 'property_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('owner_property');
        Schema::dropIfExists('property_photos');
        Schema::dropIfExists('properties');
        Schema::dropIfExists('tenants');
        Schema::dropIfExists('owners');
    }
};
