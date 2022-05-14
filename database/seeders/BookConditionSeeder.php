<?php

namespace Database\Seeders;

use App\Models\BookCondition;
use Illuminate\Database\Seeder;

class BookConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run()
    {
        $conditions = [
            '1' => ['name' => 'As new'],
            '2' => ['name' => 'Fine'],
            '3' => ['name' => 'Very Good'],
            '4' => ['name' => 'Good'],
            '5' => ['name' => 'Fair'],
            '6' => ['name' => 'Poor']
        ];

        foreach ($conditions as $key => $condition) {
            BookCondition::create(['id' => $key, 'name' => $condition['name']]);
        }
    }
}
