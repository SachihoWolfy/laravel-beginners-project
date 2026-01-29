<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlayerWhereController extends Controller
{
    // 1️⃣ Simple where
    public function simpleWhere()
    {
        $players = Player::where('score', '>', 50)->get();
        return response()->json($players);
    }

    // 2️⃣ Multiple conditions
    public function multipleWhere()
    {
        $players = Player::where('score', '>', 50)
            ->where('name', 'like', '%John%')
            ->get();
        return response()->json($players);
    }

    // 3️⃣ orWhere
    public function orWhereExample()
    {
        $players = Player::where('score', '>', 50)
            ->orWhere('name', 'like', '%Doe%')
            ->get();
        return response()->json($players);
    }

    // 4️⃣ Where in / not in
    public function whereInNotIn()
    {
        $players = Player::whereIn('id', [1, 2, 3])
            ->whereNotIn('score', [0, 5])
            ->get();
        return response()->json($players);
    }

    // 5️⃣ Where null / not null
    public function whereNullNotNull()
    {
        $players = Player::whereNull('profile_id')
            ->orWhereNotNull('score')
            ->get();
        return response()->json($players);
    }

    // 6️⃣ Where between / not between
    public function whereBetweenNotBetween()
    {
        $players = Player::whereBetween('score', [10, 50])
            ->orWhereNotBetween('score', [60, 100])
            ->get();
        return response()->json($players);
    }

    // 7️⃣ Where date / where month / where year
    public function whereDateExamples()
    {
        $players = Player::whereDate('created_at', now()->toDateString())
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->get();
        return response()->json($players);
    }

    // 8️⃣ Where has / orWhereHas (relationship filters)
    public function whereHasRelationship()
    {
        // Players with at least one game session with score > 50
        $players = Player::whereHas('gameSessions', function($q){
            $q->where('score', '>', 50);
        })->get();

        // Players with profile OR game session score > 100
        $playersOr = Player::whereHas('profile')
            ->orWhereHas('gameSessions', function($q){
                $q->where('score', '>', 100);
            })->get();

        return response()->json([
            'has_session_gt_50' => $players,
            'has_profile_or_session_gt_100' => $playersOr
        ]);
    }

    // 9️⃣ Where column comparison
    public function whereColumn()
    {
        $players = Player::whereColumn('score', '>=', 'id')->get();
        return response()->json($players);
    }

    // 🔟 Nested where
    public function nestedWhere()
    {
        $players = Player::where(function($q){
            $q->where('score', '>', 50)
                ->where('name', 'like', '%John%');
        })->orWhere(function($q){
            $q->where('score', '<', 10)
                ->where('name', 'like', '%Doe%');
        })->get();

        return response()->json($players);
    }

    // 1️⃣1️⃣ Raw where
    public function rawWhere()
    {
        $players = Player::whereRaw('score > ? AND name like ?', [50, '%John%'])->get();
        return response()->json($players);
    }

    // 1️⃣2️⃣ Exists / doesntExist
    public function existsExamples()
    {
        $players = Player::whereHas('gameSessions')->get(); // players with sessions
        $playersNoSession = Player::whereDoesntHave('gameSessions')->get(); // without sessions

        return response()->json([
            'with_sessions' => $players,
            'without_sessions' => $playersNoSession
        ]);
    }

    // 1️⃣3️⃣ Aggregates with where
    public function aggregatesWhere()
    {
        $count = Player::where('score', '>', 50)->count();
        $max = Player::where('score', '>', 50)->max('score');
        $sum = Player::where('score', '>', 50)->sum('score');

        return response()->json([
            'count' => $count,
            'max' => $max,
            'sum' => $sum
        ]);
    }
}
