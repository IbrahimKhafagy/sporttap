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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('playground_id')->constrained()->onDelete('cascade');
            $table->date('reservation_date');
            $table->time('reservation_time');
            $table->time('match_time')->nullable();
            $table->enum('type', ['special', 'competitive', 'friendly']);
            $table->decimal('total_price', 10, 2);
            $table->decimal('discount', 10, 2)->nullable();
            $table->string('coupon')->nullable();
            $table->decimal('fees', 10, 2)->nullable();
            $table->decimal('grand_total', 10, 2);
            $table->decimal('paid_amount', 10, 2)->nullable();
            $table->enum('status', ['pending_payment', 'partial_payment', 'payment_failed', 'confirmed', 'cancelled', 'refunded', 'completed']);
            $table->enum('payment_type', ['all', 'part']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
