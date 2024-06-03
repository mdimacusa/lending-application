<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use App\Models\User;
class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'unique_id'     => rand(11111111,99999999),
            'name'          => "Super Admin",
            'email'         => "superadmin@gmail.com",
            'pincode'       => 1111,
            'password'      => "admin123",
            'role'          => "SUPER ADMINISTRATOR",
            'status'        => "ACTIVE",
        ]);
    }
}
