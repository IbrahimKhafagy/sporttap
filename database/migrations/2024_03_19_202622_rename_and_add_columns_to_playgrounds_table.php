<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('playgrounds', function (Blueprint $table) {
            // Rename the existing 'price' column to 'price_per_60'
        //    $table->renameColumn('price', 'price_per_60');

            // Add new columns 'price_per_90', 'price_per_120', 'price_per_180'
            // $table->decimal('price_per_90', 10, 2)->nullable()->after('price_per_60');
            // $table->decimal('price_per_120', 10, 2)->nullable()->after('price_per_90');
            // $table->decimal('price_per_180', 10, 2)->nullable()->after('price_per_120');
            // $table->decimal('sale_price', 8, 2)->nullable()->after('price_per_180');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('playgrounds', function (Blueprint $table) {
        //     //
        // });
    }
};
