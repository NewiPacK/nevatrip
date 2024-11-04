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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('event_id');
            $table->string('event_date', 10);
            $table->integer('ticket_adult_price')->nullable();
            $table->integer('ticket_adult_quantity')->nullable();
            $table->integer('ticket_kid_price')->nullable();
            $table->integer('ticket_kid_quantity')->nullable();
            $table->string('barcode', 120)->unique();
            $table->integer('user_id')->nullable();
            $table->integer('equal_price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
