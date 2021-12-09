<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'name'=>'Turhan',
            'email'=>'turhan@example.com',
            'password'=>Hash::make(1234),
        ]);

        DB::table('admins')->insert([
            'name'=>'Sefa',
            'email'=>'sefa@example.com',
            'password'=>Hash::make(102030),
        ]);
    }
}
