<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chantier;
use App\Models\Devis;
use App\Models\Stock;

class DashboardController extends Controller
{
    public function index()
    {
        return response()->json([
            'stats' => [
                'chantiers_en_cours' => Chantier::where('status', 'en_cours')->count(),
                'chantiers_termines' => Chantier::where('status', 'termine')->count(),
                'devis_en_attente' => Devis::where('status', 'en_attente')->count(),
                'devis_valides' => Devis::where('status', 'valide')->count(),
                'stocks_rupture' => Stock::where('quantite', '<=', 0)->count(),
                'total_stocks' => Stock::count(),
            ],
            'chantiers' => Chantier::latest()->take(5)->get(),
        ]);
    }
}