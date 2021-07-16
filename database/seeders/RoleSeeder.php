<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run()
    {
        $roles = [
            '1' => 'Administrator', 
            '2' => 'Student'
        ];

        foreach ($roles as $key => $role) {
            Role::create(['id' => $key, 'name' => $role]);
        }
    }
}
