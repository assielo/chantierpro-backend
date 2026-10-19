<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reserve;
use Illuminate\Http\Request;

class ReserveController extends Controller
{
    public function index($projectId)
    {
        return response()->json(Reserve::where('project_id', $projectId)->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string',
        ]);

        $reserve = Reserve::create($validated);

        return response()->json($reserve, 201);
    }

    public function updateStatus(Request $request, $id)
    {
        $reserve = Reserve::findOrFail($id);
        
        $validated = $request->validate([
            'status' => 'required|string|in:Ouverte,En cours,Résolue',
        ]);

        $reserve->update($validated);

        return response()->json(['message' => 'Statut mis à jour avec succès', 'reserve' => $reserve]);
    }
}