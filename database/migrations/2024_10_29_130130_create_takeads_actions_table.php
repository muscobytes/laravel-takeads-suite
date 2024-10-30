<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function getTableName(): string
    {
        return config('takeads.suite.table_prefix') . 'actions';
    }


    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->getTableName(), function (Blueprint $table) {
            $table->id();
            $table->uuid('external_id')->unique();
            $table->unsignedBigInteger('external_numeric_id');
            $table->uuid('adspace_id');
            $table->foreignId('merchant_id')
                ->constrained('takeads_merchants');
            $table->uuid('program_id');
            $table->enum('status', [
                'PENDING',
                'CONFIRMED',
                'CANCELED',
                'SETTLED'
            ]);
            $table->string('sub_id')->nullable();
            $table->decimal('order_amount', 12, 2);
            $table->decimal('publisher_revenue', 12, 2);
            $table->foreignId('currency_id')
                ->constrained('takeads_currencies');
            $table->enum('type', [
                'SALE',
                'LEAD',
                'CLICK',
                'BONUS'
            ]);
            $table->dateTimeTz('order_date');
            $table->dateTimeTz('remote_created_at');
            $table->dateTimeTz('remote_updated_at');
            $table->foreignId('country_id')
                ->constrained('takeads_countries');
            $table->string('click_id')->nullable();
            $table->string('coupon_id');
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
