<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pricing;

class PricingController extends Controller
{
    public function index(Request $request)
    {
        $pricings = Pricing::orderBy('cost', 'desc')->get();
        return response()->json($pricings);
    }

    public function getActivePricings(Request $request)
    {
        $pricings = Pricing::where('status', 'Active')->orderBy('cost', 'desc')->get();
        return response()->json($pricings);
    }

    public function store(Request $request)
    {
        if (Pricing::count() >= 3) {
            return response()->json([
                'message' => 'Maximum of 3 pricing options are allowed.'
            ], 422);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'cost' => 'required|numeric|min:0',
            'discount_cost' => 'nullable|numeric|min:0',
            'details' => 'nullable|string',
            'status' => 'required|in:Active,Inactive',
        ]);

        $pricing = Pricing::create($request->all());

        return response()->json([
            'message' => 'Pricing option created successfully!',
            'data' => $pricing
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $pricing = Pricing::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'cost' => 'required|numeric|min:0',
            'discount_cost' => 'nullable|numeric|min:0',
            'details' => 'nullable|string',
            'status' => 'required|in:Active,Inactive',
        ]);

        $pricing->update($request->all());

        return response()->json([
            'message' => 'Pricing option updated successfully!',
            'data' => $pricing
        ]);
    }

    public function destroy($id)
    {
        $pricing = Pricing::findOrFail($id);
        $pricing->delete();

        return response()->json([
            'message' => 'Pricing option deleted successfully!'
        ]);
    }
}
