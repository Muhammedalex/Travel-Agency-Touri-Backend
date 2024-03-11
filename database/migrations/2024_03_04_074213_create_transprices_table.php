<?php

use App\Models\Country;
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
        Schema::create('transprices', function (Blueprint $table) {
            $table->id();
            $table->string('price');
            $table->foreignIdFor(Transportation::class)->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignIdFor(Country::class)->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transprices');
    }
};
