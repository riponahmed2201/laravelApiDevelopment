<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class insert_records_in_users_table extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [   'name' => 'ripon',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('12345678')
            ],
            [   'name' => 'nur',
                'email' => 'nur@gmail.com',
                'password' => bcrypt('12345678')
            ]
        ];

        User::insert($users);
    }
}
