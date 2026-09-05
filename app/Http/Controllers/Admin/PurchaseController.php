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
        $query = ReportPurchase::with(['reportDetail:id,title', 'pricing:id,title,cost'])->latest();

        if ($request->has('search') && $request->search != '') {
            $query->where('customer_name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $purchases = $query->paginate(20);
        return view('admin.purchases.index', compact('purchases'));
    }

    /**
     * Remove the specified purchase from storage.
     */
    public function destroy($id)
    {
        $purchase = ReportPurchase::findOrFail($id);
        $purchase->delete();
        return redirect()->back()->with('success', 'Purchase record deleted successfully.');
    }
}
