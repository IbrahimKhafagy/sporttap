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
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar');
            $table->string('name_en');
            $table->text('desc_ar')->nullable();
            $table->text('desc_en')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->foreignId('provider_id')->constrained()->onDelete('cascade');
            $table->string('phone')->nullable();
            $table->foreignId('city_id')->constrained()->onDelete('cascade');
            $table->foreignId('area_id')->constrained()->onDelete('cascade');
            $table->double('lat')->nullable();
            $table->double('lng')->nullable();
            $table->text('address_details')->nullable();
            $table->json('services')->nullable();
            $table->json('social')->nullable();
            $table->enum('status', ['pending', 'active', 'inactive', 'under_review'])->default('pending');
            $table->foreignId('logo')->nullable()->constrained('media')->onDelete('set null');
            $table->json('images')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('places');
    }
};
