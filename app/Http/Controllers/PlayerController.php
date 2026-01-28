<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function index()
    {
        return response()->json(Player::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'score' => 'required|integer|min:0',
        ]);

        $player = Player::create($validated);

        return response()->json($player, 201);
    }

    public function show(Player $player)
    {
        return response()->json($player);
    }

    public function update(Request $request, Player $player)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'score' => 'sometimes|integer|min:0',
        ]);

        $player->update($validated);

        return response()->json($player);
    }

    public function destroy(Player $player)
    {
        $player->delete();

        return response()->json(['message' => 'Player deleted']);
    }
}
