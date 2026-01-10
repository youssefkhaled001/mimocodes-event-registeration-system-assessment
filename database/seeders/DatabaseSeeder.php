<?php

namespace Database\Seeders;

use App\Models\Attendee;
use App\Models\Event;
use App\Models\Registeration;
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

        Event::factory(300)->create([]);
        echo "Seeded Events\n";
        Attendee::factory(700)->create([]);
        echo "Seeded Attendees\n";
        Registeration::factory(count: 3000)->create();
        echo "Seeded Registerations\n";
    }
}
