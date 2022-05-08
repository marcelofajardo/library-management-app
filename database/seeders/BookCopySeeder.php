<?php

namespace Database\Seeders;

use App\Models\BookCopy;
use Illuminate\Database\Seeder;

class BookCopySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run()
    {
        $copies = [
            '1' =>  ['book_id' => '1', 'price' => '10', 'date_of_purchase' => '2022-05-01 00:00:00', 'publication_date' => '2022-04-01 00:00:00', 'condition_id' => '1', 'edition' => '1', 'book_status_id' => '2'],
            '2' =>  ['book_id' => '1', 'price' => '20', 'date_of_purchase' => '2022-05-01 00:00:00', 'publication_date' => '2022-04-01 00:00:00', 'condition_id' => '2', 'edition' => '1', 'book_status_id' => '1'],
            '3' =>  ['book_id' => '2', 'price' => '24', 'date_of_purchase' => '2022-05-01 00:00:00', 'publication_date' => '2021-05-01 00:00:00', 'condition_id' => '3', 'edition' => '1', 'book_status_id' => '2'],
            '4' =>  ['book_id' => '2', 'price' => '30', 'date_of_purchase' => '2022-05-01 00:00:00', 'publication_date' => '2021-05-01 00:00:00', 'condition_id' => '4', 'edition' => '1', 'book_status_id' => '1'],
            '5' =>  ['book_id' => '3', 'price' => '16', 'date_of_purchase' => '2022-05-01 00:00:00', 'publication_date' => '2020-05-01 00:00:00', 'condition_id' => '5', 'edition' => '1', 'book_status_id' => '2'],
            '6' =>  ['book_id' => '3', 'price' => '10', 'date_of_purchase' => '2022-05-01 00:00:00', 'publication_date' => '2020-05-01 00:00:00', 'condition_id' => '6', 'edition' => '1', 'book_status_id' => '1'],
            '7' =>  ['book_id' => '4', 'price' => '25', 'date_of_purchase' => '2022-05-01 00:00:00', 'publication_date' => '2010-05-01 00:00:00', 'condition_id' => '1', 'edition' => '1', 'book_status_id' => '1'],
            '8' =>  ['book_id' => '4', 'price' => '30', 'date_of_purchase' => '2022-05-01 00:00:00', 'publication_date' => '2010-05-01 00:00:00', 'condition_id' => '2', 'edition' => '1', 'book_status_id' => '1'],
            '9' =>  ['book_id' => '5', 'price' => '20', 'date_of_purchase' => '2022-05-01 00:00:00', 'publication_date' => '2022-05-01 00:00:00', 'condition_id' => '3', 'edition' => '1', 'book_status_id' => '1'],
            '10' =>  ['book_id' => '5', 'price' => '39', 'date_of_purchase' => '2022-05-01 00:00:00', 'publication_date' => '2022-05-01 00:00:00', 'condition_id' => '4', 'edition' => '1', 'book_status_id' => '1'],
            '11' =>  ['book_id' => '6', 'price' => '27', 'date_of_purchase' => '2022-05-01 00:00:00', 'publication_date' => '2012-05-01 00:00:00', 'condition_id' => '5', 'edition' => '1', 'book_status_id' => '1'],
            '12' =>  ['book_id' => '6', 'price' => '10', 'date_of_purchase' => '2022-05-01 00:00:00', 'publication_date' => '2012-05-01 00:00:00', 'condition_id' => '6', 'edition' => '1', 'book_status_id' => '1'],
            '13' =>  ['book_id' => '7', 'price' => '20', 'date_of_purchase' => '2022-05-01 00:00:00', 'publication_date' => '2006-05-01 00:00:00', 'condition_id' => '1', 'edition' => '1', 'book_status_id' => '1'],
            '14' =>  ['book_id' => '7', 'price' => '30', 'date_of_purchase' => '2022-05-01 00:00:00', 'publication_date' => '2006-05-01 00:00:00', 'condition_id' => '2', 'edition' => '1', 'book_status_id' => '1'],
            '15' =>  ['book_id' => '8', 'price' => '32', 'date_of_purchase' => '2022-05-01 00:00:00', 'publication_date' => '2001-05-01 00:00:00', 'condition_id' => '3', 'edition' => '1', 'book_status_id' => '1'],
            '16' =>  ['book_id' => '8', 'price' => '24', 'date_of_purchase' => '2022-05-01 00:00:00', 'publication_date' => '2001-05-01 00:00:00', 'condition_id' => '4', 'edition' => '1', 'book_status_id' => '1'],
            '17' =>  ['book_id' => '9', 'price' => '45', 'date_of_purchase' => '2022-05-01 00:00:00', 'publication_date' => '1997-05-01 00:00:00', 'condition_id' => '5', 'edition' => '1', 'book_status_id' => '1'],
            '18' =>  ['book_id' => '9', 'price' => '32', 'date_of_purchase' => '2022-05-01 00:00:00', 'publication_date' => '1997-05-01 00:00:00', 'condition_id' => '6', 'edition' => '1', 'book_status_id' => '1'],
            '19' =>  ['book_id' => '10', 'price' => '12', 'date_of_purchase' => '2022-05-01 00:00:00', 'publication_date' => '2003-05-01 00:00:00', 'condition_id' => '1', 'edition' => '1', 'book_status_id' => '1'],
            '20' =>  ['book_id' => '10', 'price' => '32', 'date_of_purchase' => '2022-05-01 00:00:00', 'publication_date' => '2003-05-01 00:00:00', 'condition_id' => '2', 'edition' => '1', 'book_status_id' => '1'],
        ];

        foreach($copies as $key => $copy) {
            BookCopy::create([
                'id' => $key,
                'book_id' => $copy['book_id'],
                'price' => $copy['price'],
                'date_of_purchase' => $copy['date_of_purchase'],
                'publication_date' => $copy['publication_date'],
                'condition_id' => $copy['condition_id'],
                'book_status_id' => $copy['book_status_id'],
                'edition' => $copy['edition']
            ]);
        }
    }
}
