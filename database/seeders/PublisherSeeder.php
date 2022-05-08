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
        $publishers = ['Oxford Press', 'Harper Collins', 'Penguin', 'Simon and Schuster', 'Macmillan', 'Faber & Faber'];

        foreach ($publishers as $publisher) {
            Publisher::create(['name' => $publisher]);
        }
    }
}
