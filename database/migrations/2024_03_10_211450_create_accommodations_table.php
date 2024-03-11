<?php

use App\Models\City;
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
        Schema::create('accommodations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->tinyInteger('rate');
            $table->string('mobile');
            $table->string('address');
            $table->string('email');
            $table->boolean('share');
            $table->string('note');
            $table->string('cover');
            $table->string('video');
            $table->string('type');
            $table->foreignIdFor(City::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accommodations');
    }
};
