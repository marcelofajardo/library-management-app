<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run()
    {
        User::create(['name' => 'Filip Filipovic', 'email' => 'admin@mail.com', 'role_id' => '1', 'password' => Hash::make('12345678')]);
    }
}
