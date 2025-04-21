<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Kolom name sebagai string
            $table->timestamps(); // Kolom created_at dan updated_at otomatis
        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
};