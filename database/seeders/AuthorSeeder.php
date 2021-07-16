<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run()
    {
        $authors = [
            '1' => 'Siri Hustvedt',
            '2' => 'Paul Auster', 
            '3' => 'Margaret Atwood',
            '4' => 'Danilo Kis', 
            '5' => 'James Baldwin', 
            '6' => 'Julian Barnes',
            '7' => 'Steven Fry'
        ];

        foreach($authors as $key => $author) {
            Author::create(['id' => $key, 'name' => $author]);
        }
        
    }
}
