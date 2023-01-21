<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'zaenal@gmail.com',
                'password' => bcrypt('2021210090'),
                'remember_token' => null,
            ],
        ];

        User::insert($users);
    }
}
