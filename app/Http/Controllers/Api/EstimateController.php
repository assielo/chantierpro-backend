<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EstimateController extends Controller
{
    /**
     * 3. Génération et Structuration des Devis (Export PDF)
     */
    public function downloadPdf($id)
    {
        $filePath = storage_path("app/public/estimates/devis_{$id}.pdf");
        
        if (!file_exists($filePath)) {
            return response()->json(['message' => 'Fichier de devis introuvable'], 404);
        }

        return response()->download($filePath);
    } 

    /**
     * Traitement du Formulaire de Saisie Dynamique et Calculs
     */
    public function store(Request $request)
    {
        // 4. Validation et Intégrité : Vérification rigoureuse des données entrantes
        $validated = $request->validate([
            'budget' => 'required|numeric|min:0',
            'land_surface' => 'required|numeric|min:1',
            'city' => 'required|string',
            'num_rooms' => 'required|integer|min:1',
            'finishing_level' => 'required|string',
            'roof_type' => 'required|string',
        ]);

        // 2. Moteur de Calcul d'Estimations (Matériaux, main-d'œuvre, surfaces)
        $budget = $validated['budget'];
        $surface = $validated['land_surface'];
        
        $livingSurface = $surface * 0.4; // 40% de la surface du terrain
        $cimentSacs = $livingSurface * 3.5; // Estimation des sacs de ciment
        $mainDoeuvre = $budget * 0.35; // 35% du budget alloué à la main-d'œuvre
        $margeEntreprise = $budget * 0.10; // Marge / Frais annexes

        // 3. Génération et Structuration des Devis (Format JSON prêt pour Flutter)
        $structuredEstimate = [
            'id' => rand(1, 1000), // ID fictif ou ID de la base de données
            'parameters' => [
                'city' => $validated['city'],
                'num_rooms' => $validated['num_rooms'],
                'finishing_level' => $validated['finishing_level'],
                'roof_type' => $validated['roof_type'],
            ],
            'metrics' => [
                'land_surface_m2' => $surface,
                'living_surface_m2' => round($livingSurface, 2),
                'ciment_sacs' => round($cimentSacs),
            ],
            'financials' => [
                'main_doeuvre_fcfa' => round($mainDoeuvre, 2),
                'marge_fcfa' => round($margeEntreprise, 2),
                'total_budget_fcfa' => $budget,
            ],
            'created_at' => now()->toDateTimeString(),
        ];

        // 1. & 3. Retour structuré des résultats au format JSON attendu par l'interface client
        return response()->json([
            'success' => true,
            'message' => 'Estimation et métrés calculés avec succès',
            'data' => $structuredEstimate
        ], 200);
    }
}