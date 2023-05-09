<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //php artisan db:seed --class=UserSeeder
        User::truncate();
        User::create([
            'username' => 'admin',
            'password' => Hash::make('admin'),
        ]);
    }
}
