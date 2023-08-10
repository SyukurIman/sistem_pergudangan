<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserTableSeeder::class,
        ]);

        $this->command->info('All tables seeded!');
    }
}

class UserTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        User::create([
            'username' => 'admin',
            'status_id' => 0,
            'password' => Hash::make('admin'),
        ]);
    }
}
