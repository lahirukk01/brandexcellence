<?php

use App\Category;
use App\Company;
use App\IndustryCategory;
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
//        Category::truncate();
//        IndustryCategory::truncate();
        Company::truncate();
        User::truncate();

        DB::table('roles')->insert([
            ['name' => 'super'],
            ['name' => 'admin'],
            ['name' => 'judge'],
            ['name' => 'client']
        ]);

        DB::table('users')->insert([
            'name' => 'Lahiru Super',
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
                'name' => 'Local Brand of the Year',
                'code' => 'LB'
            ],
            [
                'name' => 'Service Brand of the Year',
                'code' => 'SB'
            ],
            [
                'name' => 'Product Brand of the Year',
                'code' => 'PB'
            ],
            [
                'name' => 'B2B Brand of the Year',
                'code' => 'B2B'
            ],
            [
                'name' => 'Turnaround Brand of the Year',
                'code' => 'TB'
            ],
            [
                'name' => 'CSR Brand of the Year',
                'code' => 'CSR'
            ],
            [
                'name' => 'Export Brand of the Year',
                'code' => 'EXP'
            ],
            [
                'name' => 'Innovative Brand of the Year',
                'code' => 'INV'
            ],
            [
                'name' => 'International Brand of the Year',
                'code' => 'INT'
            ],
            [
                'name' => 'Online Brand of the Year',
                'code' => 'OB'
            ],
            [
                'name' => 'Best New Entrant Brand of the Year',
                'code' => 'BNE'
            ],
            [
                'name' => 'Regional Brand of the Year',
                'code' => 'RB'
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
