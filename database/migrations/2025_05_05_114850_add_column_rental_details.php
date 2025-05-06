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
        Schema::table('rental_details', function (Blueprint $table) {
            $table->decimal('harga_per_jam', 15, 2); // Assuming 15 digits with 2 decimal places
            $table->decimal('sub_total', 15, 2); // Assuming 15 digits with 2 decimal places
            $table->bigInteger('kasir_id')->unsigned();
            $table->foreign('kasir_id')->references('id')->on('users');      
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rental_details', function (Blueprint $table) {
            $table->decimal('harga_per_jam', 15, 2);
            $table->decimal('sub_total', 15, 2);
            $table->bigInteger('kasir_id')->unsigned();
        });
    }
};
