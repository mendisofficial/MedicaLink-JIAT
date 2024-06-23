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
        Schema::create('vaccine_names', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vaccine_brand_id');
            $table->foreign('vaccine_brand_id')->references('id')->on('vaccine_brands')->onDelete('cascade');
            $table->string('vaccine_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaccine_names');
    }
};
