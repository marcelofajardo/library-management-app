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
        $publishers = ['Oxford Press', 'Harper Collins', 'Penguin', 'Simon and Schuster', 'Macmillan'];

        foreach ($publishers as $p) {
            Publisher::create(['name' => $p]);
        }
    }
}
