<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run()
    {
        $books = [
            '1' =>  ['title' => 'Memories of the Future', 'isbn' => '9781982102852', 'author_id' => '1', 'publisher_id' => '4'],
            '2' =>  ['title' => '4 3 2 1', 'isbn' => '3498000977222', 'author_id' => '2', 'publisher_id' => '6'],
            '3' =>  ['title' => 'What I Loved', 'isbn' => '3463000977111', 'author_id' => '1', 'publisher_id' => '3'],
            '4' =>  ['title' => 'The Sense of an Ending', 'isbn' => '3463000111333', 'author_id' => '6', 'publisher_id' => '2'],
            '5' =>  ['title' => 'The Only Story', 'isbn' => '3463004377444', 'author_id' => '6', 'publisher_id' => '3'],
            '6' =>  ['title' => 'Mythos', 'isbn' => '3461004377555', 'author_id' => '7', 'publisher_id' => '3'],
            '7' =>  ['title' => 'The Fire Next Time', 'isbn' => '1111004377666', 'author_id' => '5', 'publisher_id' => '1'],
            '8' =>  ['title' => 'The Handmaid\'s Tale', 'isbn' => '3463204377777', 'author_id' => '3', 'publisher_id' => '3'],
            '9' =>  ['title' => 'Alias Grace', 'isbn' => '3464343773432888', 'author_id' => '3', 'publisher_id' => '3'],
            '10' =>  ['title' => 'The Blazing World', 'isbn' => '3463004377000', 'author_id' => '1', 'publisher_id' => '5'],
        ];

        foreach($books as $key => $book) {
            Book::create([
                'id' => $key,
                'title' => $book['title'],
                'isbn' => $book['isbn'],
                'author_id' => $book['author_id'],
                'publisher_id' => $book['publisher_id']
            ]);
        }
    }
}
