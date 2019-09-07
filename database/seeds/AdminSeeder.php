<?php

use Illuminate\Database\Seeder;
use App\Entities\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password_txt' => 'admin',
            'password' => bcrypt('admin'),
            'mobile' => '9898989898',
            'role' => 'admin'
        ];
        User::create($user);
    }
}
