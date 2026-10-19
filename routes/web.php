<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\EstimateController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\ReserveController;
use App\Http\Controllers\StockController;

// Route de connexion publique (Accessible via POST /api/login)

Route::post('/api/v1/auth/login', [AuthController::class, 'login']);


// Routes publiques ou ressources globales
Route::apiResource('projects', ProjectController::class);
Route::apiResource('journals', JournalController::class);

// Routes sécurisées de l'application (Protégées par Sanctum)
Route::middleware('auth:sanctum')->group(function () {

    // 1. Devis & Métrés
    Route::post('/estimates', [EstimateController::class, 'store']);
    Route::get('/estimates/{id}/pdf', [EstimateController::class, 'downloadPdf']);

    // 2. Réserves & Anomalies
    Route::get('/projects/{projectId}/reserves', [ReserveController::class, 'index']);
    Route::post('/reserves', [ReserveController::class, 'store']);
    Route::patch('/reserves/{id}/status', [ReserveController::class, 'updateStatus']);

    // 3. Stocks & Matériaux
    Route::get('/projects/{projectId}/stocks', [StockController::class, 'index']);
    Route::post('/projects/{projectId}/stocks', [StockController::class, 'store']);

    // 4. Journal de Chantier
    Route::get('/projects/{projectId}/journal', [JournalController::class, 'show']);
    Route::post('/projects/{projectId}/journal', [JournalController::class, 'store']);
});