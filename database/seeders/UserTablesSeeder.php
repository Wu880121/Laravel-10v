<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            User::create([
            'firstname' => 'Test',
			'lastname' =>'Admin',
            'email' => 'TestAdmin@example.com',
            'password' => Hash::make('TestAdmin@123'),
			'role' => 'admin',
			'email_verified_at' =>now(),
        ]);
		
		
		    User::create([
            'firstname' => 'Test',
			'lastname' =>'User',
            'email' => 'TestUser@example.com',
            'password' => Hash::make('TestUser@123'),
			'role' => 'user',
			'email_verified_at' =>now(),
        ]);

        // 也可以用迴圈大量產生假資料（搭配 factory）
        User::factory()->count(15)->create();
    }
}
