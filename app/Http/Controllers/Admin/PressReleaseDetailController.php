<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PressReleaseDetail;
use App\Models\PressRelease;

class PressReleaseDetailController extends Controller
{
    public function index(Request $request)
    {
        $query = PressReleaseDetail::with('pressRelease:id,title');

        if ($request->has('search') && $request->search != '') {
            $query->whereHas('pressRelease', function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%');
            });
        }

        $details = $query->orderBy('created_at', 'desc')->paginate(20);

        return response()->json($details);
    }

    public function store(Request $request)
    {
        $request->validate([
            'press_release_id' => 'required|exists:press_releases,id',
            'content' => 'nullable|string',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ]);

        $detail = PressReleaseDetail::create($request->all());

        return response()->json([
            'message' => 'Press release detail saved successfully!',
            'data'    => $detail->load('pressRelease:id,title'),
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $detail = PressReleaseDetail::findOrFail($id);

        $request->validate([
            'press_release_id' => 'required|exists:press_releases,id',
            'content' => 'nullable|string',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ]);

        $detail->update($request->all());

        return response()->json([
            'message' => 'Press release detail updated successfully!',
            'data'    => $detail->load('pressRelease:id,title'),
        ]);
    }

    public function destroy($id)
    {
        $detail = PressReleaseDetail::findOrFail($id);
        $detail->delete();

        return response()->json([
            'message' => 'Press release detail deleted successfully!',
        ]);
    }

    public function getPressReleasesList()
    {
        $pressReleases = PressRelease::select('id', 'title')->orderBy('title', 'asc')->get();
        return response()->json($pressReleases);
    }
}
