<?php

use App\Http\Controllers\PlayerController;
use \App\Http\Controllers\GameSessionController;
use \App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayerWhereController;

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


Route::prefix('dummy')->group(function(){
    Route::get('simple-where', [PlayerWhereController::class, 'simpleWhere']);
    Route::get('multiple-where', [PlayerWhereController::class, 'multipleWhere']);
    Route::get('or-where', [PlayerWhereController::class, 'orWhereExample']);
    Route::get('in-not-in', [PlayerWhereController::class, 'whereInNotIn']);
    Route::get('null-not-null', [PlayerWhereController::class, 'whereNullNotNull']);
    Route::get('between-not-between', [PlayerWhereController::class, 'whereBetweenNotBetween']);
    Route::get('date-examples', [PlayerWhereController::class, 'whereDateExamples']);
    Route::get('has-relationship', [PlayerWhereController::class, 'whereHasRelationship']);
    Route::get('column', [PlayerWhereController::class, 'whereColumn']);
    Route::get('nested', [PlayerWhereController::class, 'nestedWhere']);
    Route::get('raw', [PlayerWhereController::class, 'rawWhere']);
    Route::get('exists', [PlayerWhereController::class, 'existsExamples']);
    Route::get('aggregates', [PlayerWhereController::class, 'aggregatesWhere']);
});
