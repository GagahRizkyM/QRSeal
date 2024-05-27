<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class users extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert(
            [

                'name' => 'Gagah',
                'email' => 'gagah@gmail.com',
                'password' => Hash::make('gagah'),
                'role' => 'admin'
            ]
        );
    }
}
