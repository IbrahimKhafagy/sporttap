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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('sport_type', ['Tennis', 'Padel'])->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->enum('level', ['junior', 'middle', 'advanced'])->nullable();
            $table->text('check')->nullable();
            $table->string('age')->nullable();
            $table->boolean('is_active')->default(0);


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('sport_type');
            $table->dropColumn('gender');
            $table->dropColumn('level');
            $table->dropColumn('check');
            $table->dropColumn('age');
            $table->dropColumn('is_active');



        });
    }
};
