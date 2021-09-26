<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'name' => 'Admin',
                'email' => 'admin@itsolutionstuff.com',
                'user_type' => '2',
                'password' => bcrypt('123456'),
            ],
            [
                'name' => 'OrgAdmin',
                'email' => 'orgAdmin@itsolutionstuff.com',
                'user_type' => '1',
                'password' => bcrypt('123456'),
            ],

            [
                'name' => 'User',
                'email' => 'user@itsolutionstuff.com',
                'user_type' => '0',
                'password' => bcrypt('123456'),
            ],
        ];

        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}