<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReportPurchase;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the purchases.
     */
    public function index(Request $request)
    {
        $query = ReportPurchase::with(['reportDetail', 'pricing'])->latest();
        $purchases = $query->paginate(15);
        return response()->json($purchases);
    }

    /**
     * Remove the specified purchase from storage.
     */
    public function destroy($id)
    {
        $purchase = ReportPurchase::findOrFail($id);
        $purchase->delete();
        return response()->json(['message' => 'Purchase record deleted successfully.']);
    }
}
