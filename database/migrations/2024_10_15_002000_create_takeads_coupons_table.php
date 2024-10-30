<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function getTableName(): string
    {
        return config('takeads.suite.table_prefix') . 'coupons';
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string('external_id')->unique();
            $table->boolean('is_active')->default(true);
            $table->string('tracking_link');
            $table->string('name');
            $table->string('code')->nullable(true);
            $table->foreignId('merchant_id')->constrained('takeads_merchants');
            $table->string('image_uri');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->getTableName());
    }
};
