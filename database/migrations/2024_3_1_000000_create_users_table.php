<?php

use App\Models\Country;
use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
// Table users {
//     id integer [primary key] .
//     name varchar.
//     mobile varchar
//     email varchar.
//     password varchar
//     photo varchar 
//     role_id varchar
//     country_id integer
//     created_at timestamp

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('mobile')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('photo')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->string('role');
            $table->foreignIdFor(Country::class)->constrained();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
