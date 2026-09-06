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

        return view('admin.press_release_details.index', compact('details'));
    }

    public function edit($id)
    {
        $detail = PressReleaseDetail::findOrFail($id);
        return view('admin.press_release_details.edit', compact('detail'));
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
            'canonical_tag' => 'nullable|string',
            'meta_robots' => 'nullable|string',
            'hreflang_tags' => 'nullable|array',
            'open_graph_tags' => 'nullable|array',
            'twitter_card_tags' => 'nullable|array',
            'schema_tag' => 'nullable|string',
            'schema_tag_2' => 'nullable|string',
            'slug_url' => 'nullable|string',
            'page_main_title' => 'nullable|string',
            'breadcrumb_title' => 'nullable|string',
        ]);

        $detail->update($request->all());

        return redirect()->route('admin.press_release_details.index')->with('success', 'Press release detail updated successfully!');
    }

    public function destroy($id)
    {
        $detail = PressReleaseDetail::findOrFail($id);
        $detail->delete();

        return redirect()->back()->with('success', 'Press release detail deleted successfully!');
    }
}
