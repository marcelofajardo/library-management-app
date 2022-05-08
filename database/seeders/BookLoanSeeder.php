<?php

namespace Database\Seeders;

use App\Models\BookLoan;
use Illuminate\Database\Seeder;

class BookLoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run()
    {
        $loans = [
            '1' =>  ['book_copy_id' => '1', 'user_id' => '2', 'deadline' => '2022-05-31 00:00:00'],
            '2' =>  ['book_copy_id' => '3', 'user_id' => '2', 'deadline' => '2022-05-31 00:00:00'],
            '3' =>  ['book_copy_id' => '5', 'user_id' => '1', 'deadline' => '2022-05-31 00:00:00']
        ];

        foreach($loans as $key => $loan) {
            BookLoan::create([
                'id' => $key,
                'book_copy_id' => $loan['book_copy_id'],
                'user_id' => $loan['user_id'],
                'deadline' => $loan['deadline']
            ]);
        }
    }
}
