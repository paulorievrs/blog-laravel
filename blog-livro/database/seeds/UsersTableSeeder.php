<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*DB::table('users')->insert([
            'name' => 'Primeiro Usuário',
            'email' => 'email@email.com',
            'password' => bcrypt('secret')
        ]);*/
        factory(\App\User::class, 10)->create();
    }
}
