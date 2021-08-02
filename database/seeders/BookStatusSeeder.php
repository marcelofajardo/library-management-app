<?php

namespace Database\Seeders;

use App\Models\BookStatus;
use Illuminate\Database\Seeder;

class BookStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run()
    {
        $statuses = [
            '1' => ['name' => 'Available', 'icon' => 'badge-success'],
            '2' => ['name' => 'Checked Out', 'icon' => 'badge-danger'],
            '3' => ['name' => 'Reading Room Copy', 'icon' => 'badge-warning']
        ];

        foreach ($statuses as $key => $status) {
            BookStatus::create([
                'status' => $status['name'],
                'icon' => $status['icon']
            ]);
        }
    }
}
