<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ADMIN
        User::create([
            'username' => 'admin1',
            'password' => bcrypt('admin1'),
            'role' => 'admin'
        ]);

        // USER
        $user = User::create([
            'username' => 'user1',
            'password' => 'user1',
            'role' => 'tenants'
        ]);

        Tenant::create([
            'id_user' => $user->id,
            'no_ktp' => '3175030439332',
            'name' => "Alan Pratama",
            'date_of_birth' => '1945-08-17',
            'email' => 'user1@gmail.com',
            'phone' => '085817000942',
            'description' => 'Seorang Programmer Wanna Be'
        ]);
    }
}
