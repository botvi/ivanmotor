<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "nama" => "admin",
            "username" => "admin",
            "password" => bcrypt('password'),
            "alamat" => "Taluk kuantan, Pekanbaru, Riau",
            "role" => "admin"
        ]);
        User::create([
            "nama" => "seller",
            "username" => "seller",
            "password" => bcrypt('password'),
            "alamat" => "Taluk kuantan, Pekanbaru, Riau",
            "role" => "seller"
        ]);
    }
}
