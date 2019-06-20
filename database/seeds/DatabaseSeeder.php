<?php

use App\Category;
use App\IndustryCategory;
use App\Judge;
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
        IndustryCategory::truncate();
        Judge::truncate();
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

        DB::table('categories')->insert([
            [
                'name' => 'Category1',
                'code' => 'C1'
            ],
            [
                'name' => 'Category2',
                'code' => 'C2'
            ],
            [
                'name' => 'Category3',
                'code' => 'C3'
            ],
            [
                'name' => 'Category4',
                'code' => 'C4'
            ],
            [
                'name' => 'Category5',
                'code' => 'C5'
            ],
        ]);


        DB::table('industry_categories')->insert([
            [
                'name' => 'Banking',
                'code' => 'IC1'
            ],
            [
                'name' => 'Financial Service Providers',
                'code' => 'IC2'
            ],
            [
                'name' => 'Insurance',
                'code' => 'IC3'
            ],
            [
                'name' => 'Telecommunication',
                'code' => 'IC4'
            ],
            [
                'name' => 'IT / Internet and Software / E-Commerce',
                'code' => 'IC5'
            ],
            [
                'name' => 'Leisure, Hospitality, Travel & Tourism',
                'code' => 'IC6'
            ],
            [
                'name' => 'Education and Training Services',
                'code' => 'IC7'
            ],
            [
                'name' => 'Health Care Services / Wellness / Hospitals',
                'code' => 'IC8'
            ],
            [
                'name' => 'Construction & Real Estate',
                'code' => 'IC9'
            ],
            [
                'name' => 'Retail (Fashion / Consumer Electronics)',
                'code' => 'IC10'
            ],
            [
                'name' => 'Media and Publications',
                'code' => 'IC11'
            ],
            [
                'name' => 'FMCG – Food',
                'code' => 'IC12'
            ],
            [
                'name' => 'FMCG – Beverages',
                'code' => 'IC13'
            ],
            [
                'name' => 'FMCG – Cosmetics & Others',
                'code' => 'IC14'
            ],
            [
                'name' => 'Automotive',
                'code' => 'IC15'
            ],
            [
                'name' => 'Industrial, Manufacturing and Energy',
                'code' => 'IC16'
            ],
            [
                'name' => 'CSR / NGO and Government',
                'code' => 'IC17'
            ],
            [
                'name' => 'Modern Trade',
                'code' => 'IC18'
            ],
            [
                'name' => 'Agriculture',
                'code' => 'IC19'
            ],
            [
                'name' => 'Logistics',
                'code' => 'IC20'
            ],
        ]);
    }
}
