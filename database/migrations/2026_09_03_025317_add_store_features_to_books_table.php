<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->decimal('discount_percent', 5, 2)
                ->default(0)
                ->after('price');

            $table->string('discount_name')
                ->nullable()
                ->after('discount_percent');

            $table->dateTime('discount_start')
                ->nullable()
                ->after('discount_name');

            $table->dateTime('discount_end')
                ->nullable()
                ->after('discount_start');
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn([
                'discount_percent',
                'discount_name',
                'discount_start',
                'discount_end',
            ]);
        });
    }
};