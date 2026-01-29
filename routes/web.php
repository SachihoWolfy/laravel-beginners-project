<?php

use App\Http\Controllers\PlayerController;
use \App\Http\Controllers\GameSessionController;
use \App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/players', [PlayerController::class, 'index']);
Route::post('/players', [PlayerController::class, 'store']);
Route::get('/players/{player}', [PlayerController::class, 'show']);
Route::put('/players/{player}', [PlayerController::class, 'update']);
Route::delete('/players/{player}', [PlayerController::class, 'destroy']);


Route::get('/players/{id}/alternative', [PlayerController::class, 'showAlternative']);
//Route::resource('players', PlayerController::class);

Route::resource('game-sessions', GameSessionController::class);
Route::get('players/{player}/game-sessions', [GameSessionController::class, 'indexByPlayer']);



Route::resource('teams', TeamController::class);

// Optional: player specific teams
Route::get('players/{playerId}/teams', [TeamController::class, 'teamsByPlayer']);
