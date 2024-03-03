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
        Schema::create('actions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('place_start_id');
            $table->unsignedBigInteger('place_end_id');
            $table->foreign('place_start_id')->references('id')->on('places');
            $table->foreign('place_end_id')->references('id')->on('places');
            $table->string('img_middle');
            $table->string('img_start');
            $table->string('coordinates_start');
            $table->string('img_end');
            $table->string('coordinates_end');
            $table->string('desc');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->unsignedBigInteger('sub_category_id');
            $table->foreign('sub_category_id')->references('id')->on('sub_categories');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actions');
    }
};
