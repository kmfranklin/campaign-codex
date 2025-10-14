<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Npc;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // --- Core reference data from Open5e ---
        $this->call([
            ItemCategoriesTableSeeder::class,
            ItemRaritiesTableSeeder::class,
            DamageTypesTableSeeder::class,
            ItemsTableSeeder::class,
            WeaponsTableSeeder::class,
            ArmorsTableSeeder::class,
        ]);

        // --- Dev/test accounts ---
        $devUser = User::factory()->create([
            'name' => 'Kevin',
            'email' => 'kevin@example.com',
            'password' => bcrypt('password'),
        ]);

        // Give dev account 50 NPCs
        Npc::factory()->count(50)->create([
            'user_id' => $devUser->id,
        ]);

        // Create 2 more random users
        $otherUsers = User::factory()->count(2)->create();

        // Give each of them 50 NPCs
        foreach ($otherUsers as $user) {
            Npc::factory()->count(50)->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
