<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReportMethodology;

class ReportMethodologyController extends Controller
{
    public function index()
    {
        $methodology = ReportMethodology::first();
        return response()->json($methodology);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'content' => 'nullable|string',
        ]);

        $methodology = ReportMethodology::first();
        if ($methodology) {
            $methodology->update($validatedData);
        } else {
            $methodology = ReportMethodology::create($validatedData);
        }

        return response()->json([
            'message' => 'Report Methodology saved successfully.',
            'data' => $methodology
        ], 200);
    }
}
