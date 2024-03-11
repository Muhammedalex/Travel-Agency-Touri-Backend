<?php

use App\Models\City;
use App\Models\Transportation;
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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('mobile')->unique();
            $table->string('car_model');
            $table->tinyInteger('num_of_seats');
            $table->tinyInteger('driver_rate');
            $table->unsignedSmallInteger('driver_price');
            $table->string('note');
            $table->boolean('share');
            $table->string('picture')->nullable();
            $table->foreignIdFor(Transportation::class)->constrained()->onUpdate('cascade');
            $table->foreignIdFor(City::class)->constrained()->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
