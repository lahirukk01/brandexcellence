<?php

use App\Category;
use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        // $this->call(UsersTableSeeder::class);

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Role::truncate();
        Category::truncate();
        User::truncate();

        DB::table('roles')->insert([
            ['name' => 'super'],
            ['name' => 'admin'],
            ['name' => 'judge'],
            ['name' => 'client']
        ]);

        DB::table('users')->insert([
            'name' => 'Super User',
            'email' => 'admin@gmail.com',
            'designation' => 'Super User',
            'role_id' => 1,
            'contact_number' => '0771234567',
            'password' => Hash::make('123'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $numberOfCategories = 10;

        factory(Category::class, $numberOfCategories)->create();
    }
}
