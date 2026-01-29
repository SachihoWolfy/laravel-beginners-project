<?php

namespace Database\Seeders;

use App\Models\Player;
use App\Models\Profile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Player::all()->each(function ($player) {
            Profile::factory()->create([
                'player_id' => $player->id,
            ]);
        });
    }
}
