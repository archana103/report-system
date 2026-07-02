<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Newsletter;

class NewsletterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $newsletters = Newsletter::latest()->get();
        return response()->json($newsletters);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $newsletter = Newsletter::findOrFail($id);
            $newsletter->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Subscriber removed successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unable to remove subscriber'
            ], 500);
        }
    }
}
