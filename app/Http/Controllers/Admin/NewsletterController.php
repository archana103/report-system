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
    public function index(Request $request)
    {
        $query = Newsletter::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('email', 'like', '%' . $request->search . '%');
        }

        $newsletters = $query->latest()->paginate(20);
        return view('admin.newsletters.index', compact('newsletters'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $newsletter = Newsletter::findOrFail($id);
            $newsletter->delete();
            return redirect()->back()->with('success', 'Subscriber removed successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Unable to remove subscriber');
        }
    }
}
