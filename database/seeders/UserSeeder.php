<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $scrutinyRole = Role::where('name', 'Scrutiny')->first();
        $reviewRole = Role::where('name', 'Review')->first();
        $viewRole = Role::where('name', 'View')->first();

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $scrutiny = User::create([
            'name' => 'Muhammad Shahbaz',
            'email' => 'scrutiny1@phcip.com',
            'password' => Hash::make('password'),
        ]);
        $scrutiny->roles()->attach($scrutinyRole);
        $scrutiny = User::create([
            'name' => 'Khadija Nisar',
            'email' => 'scrutiny2@phcip.com',
            'password' => Hash::make('password'),
        ]);
        $scrutiny->roles()->attach($scrutinyRole);
        $scrutiny = User::create([
            'name' => 'Fariha Akbar',
            'email' => 'scrutiny3@phcip.com',
            'password' => Hash::make('password'),
        ]);
        $scrutiny->roles()->attach($scrutinyRole);
        $scrutiny = User::create([
            'name' => 'Qamar Shahzad',
            'email' => 'scrutiny4@phcip.com',
            'password' => Hash::make('password'),
        ]);
        $scrutiny->roles()->attach($scrutinyRole);
        $scrutiny = User::create([
            'name' => 'Khaliq Sharif',
            'email' => 'scrutiny5@phcip.com',
            'password' => Hash::make('password'),
        ]);
        $scrutiny->roles()->attach($scrutinyRole);
        $scrutiny = User::create([
            'name' => 'Scrutiny User 6',
            'email' => 'scrutiny6@phcip.com',
            'password' => Hash::make('password'),
        ]);
        $scrutiny->roles()->attach($scrutinyRole);
        $scrutiny = User::create([
            'name' => 'Scrutiny User 7',
            'email' => 'scrutiny7@phcip.com',
            'password' => Hash::make('password'),
        ]);
        $scrutiny->roles()->attach($scrutinyRole);

        $review = User::create([
            'name' => 'Review User 1',
            'email' => 'review1@phcip.com',
            'password' => Hash::make('password'),
        ]);
        $review->roles()->attach($reviewRole);

        $review = User::create([
            'name' => 'Review User 2',
            'email' => 'review2@phcip.com',
            'password' => Hash::make('password'),
        ]);
        $review->roles()->attach($reviewRole);

        $view = User::create([
            'name' => 'View User',
            'email' => 'view@phcip.com',
            'password' => Hash::make('password'),
        ]);
        $view->roles()->attach($viewRole);
    }
}
