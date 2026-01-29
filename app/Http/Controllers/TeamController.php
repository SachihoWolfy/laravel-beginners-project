<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Player;

class TeamController extends Controller
{
    public function index()
    {
        return Team::with('players')->get();
    }

    public function show(Team $team)
    {
        $team->load('players');
        return response()->json($team);
    }

    public function store(Request $request)
    {
        $team = Team::create($request->validate([
            'name' => 'required|string|max:255'
        ]));

        return response()->json($team, 201);
    }

    public function update(Request $request, Team $team)
    {
        $team->update($request->validate([
            'name' => 'sometimes|string|max:255'
        ]));

        return response()->json($team);
    }

    public function destroy(Team $team)
    {
        $team->delete();
        return response()->json(['message' => 'Team deleted']);
    }

    // Optional: get teams of a specific player
    public function teamsByPlayer($playerId)
    {
        $player = Player::with('teams')->findOrFail($playerId);
        return response()->json($player->teams);
    }
}
