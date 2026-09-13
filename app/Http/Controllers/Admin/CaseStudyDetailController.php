<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CaseStudyDetail;
use App\Models\CaseStudy;

class CaseStudyDetailController extends Controller
{
    public function index(Request $request)
    {
        $query = CaseStudyDetail::with('caseStudy:id,title');

        if ($request->has('search') && $request->search != '') {
            $query->whereHas('caseStudy', function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%');
            });
        }

        $details = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.case_study_details.index', compact('details'));
    }

    public function edit($id)
    {
        $detail = CaseStudyDetail::findOrFail($id);
        return view('admin.case_study_details.edit', compact('detail'));
    }

    public function update(Request $request, $id)
    {
        $detail = CaseStudyDetail::findOrFail($id);

        $request->validate([
            'case_study_id' => 'required|exists:case_studies,id',
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

        return redirect()->route('admin.case_study_details.index')->with('success', 'Case study detail updated successfully!');
    }

    public function destroy($id)
    {
        $detail = CaseStudyDetail::findOrFail($id);
        $detail->delete();

        return redirect()->back()->with('success', 'Case study detail deleted successfully!');
    }
}
