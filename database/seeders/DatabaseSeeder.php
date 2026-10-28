<?php

namespace Database\Seeders;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $admin = User::firstOrCreate(
            ['email' => 'admin@rootbio.test'],
            [
                'name' => 'Admin ROOTBIO',
                'password' => 'password',
                'email_verified_at' => now(),
            ],
        );

        $admin->is_admin = true;
        $admin->save();

        if (Lead::count() === 0) {
            Lead::factory()->count(12)->create();
        }
    }
}
