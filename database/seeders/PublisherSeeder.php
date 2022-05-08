<?php

namespace Database\Seeders;

use App\Models\Publisher;
use Illuminate\Database\Seeder;

class PublisherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run()
    {
        $publishers = [
            '1' => ['name' => 'Oxford Press'],
            '2' => ['name' => 'Harper Collins'],
            '3' => ['name' => 'Penguin'],
            '4' => ['name' => 'Simon and Schuster'],
            '5' => ['name' => 'Macmillan'],
            '6' => ['name' => 'Faber & Faber']
        ];

        foreach ($publishers as $key => $publisher) {
            Publisher::create(['id' => $key, 'name' => $publisher['name']]);
        }
    }
}
