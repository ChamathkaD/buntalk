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
        Schema::table('cart', function (Blueprint $table) {
            $table->date('delivery_date')->nullable();
            $table->enum('timeslot', ['Morning 8.00AM - 4.00PM', 'Evening 4.00PM - 7.00PM'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cart', function (Blueprint $table) {
            $table->dropColumn('delivery_date');
            $table->dropColumn('timeslot');
        });
    }
};
