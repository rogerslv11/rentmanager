<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('original_name');
            $table->string('path');
            $table->string('disk', 64)->default('public');
            $table->string('mime_type', 128)->nullable();
            $table->unsignedBigInteger('size')->default(0);
            $table->string('collection', 64)->nullable();
            $table->string('related_type')->nullable();
            $table->unsignedBigInteger('related_id')->nullable();
            $table->timestamps();

            $table->index(['organization_id', 'collection']);
            $table->index(['related_type', 'related_id']);
        });

        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('action', 64);
            $table->string('subject_type')->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->string('description')->nullable();
            $table->json('properties')->nullable();
            $table->string('ip_address', 64)->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();

            $table->index(['organization_id', 'created_at']);
            $table->index(['subject_type', 'subject_id']);
            $table->index('user_id');
        });

        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('property_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('email');
            $table->string('phone', 32)->nullable();
            $table->text('message')->nullable();
            $table->string('status', 32)->default('new');
            $table->timestamp('contacted_at')->nullable();
            $table->timestamps();

            $table->index('organization_id');
        });

        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('property_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('contract_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type', 64);
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('start_at');
            $table->dateTime('end_at')->nullable();
            $table->boolean('all_day')->default(false);
            $table->string('color', 16)->default('#22C55E');
            $table->timestamps();

            $table->index(['organization_id', 'start_at']);
            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
        Schema::dropIfExists('leads');
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('files');
    }
};
