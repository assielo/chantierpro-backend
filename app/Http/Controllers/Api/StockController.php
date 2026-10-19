<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index($projectId)
    {
        return response()->json(Stock::where('project_id', $projectId)->get());
    }

    public function store(Request $request, $projectId)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|numeric',
            'unit' => 'required|string|max:50',
            'alert_threshold' => 'required|numeric',
        ]);

        $validated['project_id'] = $projectId;
        $stock = Stock::create($validated);

        return response()->json($stock, 201);
    }
}