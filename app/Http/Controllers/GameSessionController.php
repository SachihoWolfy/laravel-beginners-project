<?php

namespace App\Http\Controllers;

use App\Models\GameSession;
use Illuminate\Http\Request;
use App\Models\Player;

class GameSessionController extends Controller
{
    /**
     * Display a listing of all game sessions.
     */
    public function index()
    {
        // Return all sessions with player info
        $sessions = GameSession::with('player')->get();
        return response()->json($sessions);
    }


    public function indexByPlayer(Player $player)
    {
        $sessions = $player->gameSessions()->get();
        return response()->json($sessions);
    }

    public function indexByPlayerAlternative($playerId)
    {
        // Fetch the player and eager load sessions and profile
        $player = Player::with(['profile', 'gameSessions'])->findOrFail($playerId);

        return response()->json([
            'player' => $player,
            'sessions' => $player->gameSessions,
        ]);
    }

    //N+1 problem
    public function lazyLoadingExample()
    {
        $players = Player::all(); // 1 query
        foreach ($players as $player) {
            echo $player->profile->bio; // triggers 1 query per player!
        }
    }

    public function eagerLoadingExample()
    {
        $players = Player::with('profile')->get(); // only 2 queries total
        //SELECT * FROM players;
        //SELECT * FROM profiles WHERE player_id IN (1, 2, 3, ..., N);
        foreach ($players as $player) {
            echo $player->profile->bio; // no extra queries
        }

    }

    /**
     * Store a newly created game session.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'player_id' => 'required|exists:players,id',
            'score' => 'nullable|integer|min:0',
        ]);

        $session = GameSession::create($validated);

        return response()->json($session, 201);
    }

    /**
     * Display the specified game session.
     */
    public function show(GameSession $gameSession)
    {
        $gameSession->load('player'); // eager load player
        return response()->json($gameSession);
    }

    /**
     * Update the specified game session.
     */
    public function update(Request $request, GameSession $gameSession)
    {
        $validated = $request->validate([
            'score' => 'sometimes|integer|min:0',
        ]);

        $gameSession->update($validated);

        return response()->json($gameSession);
    }

    /**
     * Remove the specified game session.
     */
    public function destroy(GameSession $gameSession)
    {
        $gameSession->delete();

        return response()->json(['message' => 'Game session deleted']);
    }
}
