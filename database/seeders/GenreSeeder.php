<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run()
    {
        $genres = ['Sci-Fi', 'Horror', 'Action', 'Mystery', 'Young Adult'];

        foreach ($genres as $g) {
            Genre::create(['name' => $g]);
        }
    }
}
