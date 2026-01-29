<?php

namespace Database\Seeders;

use App\Models\GameSession;
use App\Models\Player;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GameSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Player::all()->each(function ($player) {
            GameSession::factory()->count(3)->create([
                'player_id' => $player->id,
            ]);
        });
    }
}
