<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Use production-safe seeding
        $this->call([
            ProductionSeeder::class,
        ]);
        
        // Fallback: try factory seeding if in development
        if (app()->environment('local', 'development')) {
            try {
                User::factory()->withPersonalTeam()->create([
                    'name' => 'Factory User',
                    'email' => 'factory@example.com',
                ]);
            } catch (\Exception $e) {
                // Factory failed, but ProductionSeeder should have worked
                $this->command->info('Factory seeding skipped: ' . $e->getMessage());
            }
        }
    }
}
