<?php

namespace Modules\Admin\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->insert([
            "username" => "hossein",
            "password" => Hash::make("12345678"),
            "name" => "Hossein Masumpoor"
        ]);    }
}
