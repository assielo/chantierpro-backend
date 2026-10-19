<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    public function show(Request $request, $projectId)
    {
        $date = $request->query('date');
        $journal = Journal::where('project_id', $projectId)->where('date', $date)->first();

        if (!$journal) {
            return response()->json(['message' => 'Aucun rapport pour cette date'], 404);
        }

        return response()->json($journal);
    }

    public function store(Request $request, $projectId)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'weather' => 'nullable|string',
            'team_count' => 'nullable|integer',
            'progress_notes' => 'nullable|string',
        ]);

        $journal = Journal::updateOrCreate(
            ['project_id' => $projectId, 'date' => $validated['date']],
            $validated
        );

        return response()->json($journal, 200);
    }
}