<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $user = User::create([
        'first_name'=>'Admin',
        'last_name'=>'Test',
        'mobile'=>'01155584093',
        'email'=>'admin@admin.com',
        'role'=>'super admin',
        'country_id'=> '1',
        'password'=>Hash::make('123456')
       ]);
       $user->assignRole('super admin');
    }
}
