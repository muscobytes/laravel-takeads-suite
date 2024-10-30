<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function getTableName(): string
    {
        return config('takeads.suite.table_prefix') . 'coupon_country';
    }


    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('coupon_id')->constrained('takeads_coupons');
            $table->foreignId('country_id')->constrained('takeads_countries');
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
