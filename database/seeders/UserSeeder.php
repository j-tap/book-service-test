<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => config('app.admin.email'),
            'password' => bcrypt(config('app.admin.password')),
            'is_admin' => DB::raw('true'),
        ]);
    }
}
