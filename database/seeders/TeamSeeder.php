<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\Player;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        // Create 5 teams
        $teams = Team::factory()->count(5)->create();

        // Attach random players to each team
        Player::all()->each(function ($player) use ($teams) {
            $player->teams()->attach(
                $teams->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }
}
