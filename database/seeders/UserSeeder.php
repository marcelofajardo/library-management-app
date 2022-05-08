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

        $users = [
            '1' => ['name' => 'Admin', 'email' => 'admin@mail.com', 'role_id' => '1', 'password' => Hash::make('12345678')],
            '2' => ['name' => 'Casey Sims', 'email' => 'casey@mail.com', 'role_id' => '2', 'password' => Hash::make('12345678')],
        ];

        foreach($users as $key => $user) {
            User::create([
                'id' => $key,
                'name' => $user['name'],
                'email' => $user['email'],
                'role_id' => $user['role_id'],
                'password' => $user['password']
            ]);
        }
    }
}
