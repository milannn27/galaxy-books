<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_settings', function (Blueprint $table) {

            $table->id();

            $table->string('bank_name')->nullable();

            $table->string('account_number')->nullable();

            $table->string('account_holder')->nullable();

            $table->string('qris_image')->nullable();

            $table->boolean('qris_enabled')->default(true);

            $table->boolean('transfer_enabled')->default(true);

            $table->boolean('cod_enabled')->default(true);

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_settings');
    }
};