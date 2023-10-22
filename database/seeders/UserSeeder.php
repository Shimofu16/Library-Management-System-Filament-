<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Administrator',
                'email' => 'admin@app.com',
                'password' => Hash::make('password'),
                'role' => RoleEnum::ADMIN,
            ],
            [
                'name' => 'Librarian',
                'email' => 'librarian@app.com',
                'password' => Hash::make('password'),
                'role' => RoleEnum::LIBRARIAN,
            ],
        ];

        foreach ($users as $user) {
            \App\Models\User::create($user);
        }
    }
}
