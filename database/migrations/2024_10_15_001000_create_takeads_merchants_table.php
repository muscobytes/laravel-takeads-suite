<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public string $tableName = 'takeads_merchants';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('external_id')->unique();
            $table->string('name')->nullable()->default(null);
            $table->string('image_uri')->nullable()->default(null);
            $table->foreignId('currency_id')->nullable()->default(null)->constrained('takeads_currencies');
            $table->string('default_domain')->nullable()->default(null);
            $table->json('domains')->nullable()->default(null);
            $table->foreignId('category_id')->nullable(true)->constrained('takeads_categories');
            $table->text('description')->nullable(true);
            $table->boolean('is_active')->nullable()->default(null);
            $table->string('tracking_link')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->tableName);
    }
};
