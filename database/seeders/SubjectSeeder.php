<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run()
    {
        $subjects = ['Biology', 'Fiction', 'Non-Fiction', 'Georgraphy', 'Philosophy'];

        foreach ($subjects as $s) {
            Subject::create(['name' => $s]);
        }
    }
}
