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
        $conditions = ['As new', 'Fine', 'Very Good', 'Good', 'Fair', 'Poor'];

        foreach ($conditions as $c) {
            BookCondition::create(['name' => $c]);
        }
    }
}
