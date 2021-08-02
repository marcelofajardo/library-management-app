<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        AuthorSeeder::run();
        BookConditionSeeder::run();
        GenreSeeder::run();
        PublisherSeeder::run();
        RoleSeeder::run();
        SubjectSeeder::run();
        UserSeeder::run();
        BookStatusSeeder::run();
    }
}
