<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CaseStudy;
use Illuminate\Support\Facades\Storage;

class CaseStudyController extends Controller
{
    public function index(Request $request)
    {
        $query = CaseStudy::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('url', 'like', '%' . $search . '%');
            });
        }

        $caseStudies = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.case_studies.index', compact('caseStudies'));
    }

    public function create()
    {
        return view('admin.case_studies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'url' => 'required|string',
            'status' => 'required|string|in:Active,Inactive',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'thumbnail_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['title', 'description', 'url', 'status']);

        if ($request->hasFile('main_image')) {
            $data['main_image'] = $request->file('main_image')->store('case_studies', 's3');
        }

        if ($request->hasFile('thumbnail_image')) {
            $data['thumbnail_image'] = $request->file('thumbnail_image')->store('case_studies/thumbnails', 's3');
        }

        $caseStudy = CaseStudy::create($data);
        
        \App\Models\CaseStudyDetail::create([
            'case_study_id' => $caseStudy->id
        ]);

        return redirect()->route('admin.case_studies.index')->with('success', 'Case study created successfully');
    }

    public function edit($id)
    {
        $caseStudy = CaseStudy::findOrFail($id);
        return view('admin.case_studies.edit', compact('caseStudy'));
    }

    public function update(Request $request, $id)
    {
        $caseStudy = CaseStudy::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'url' => 'required|string',
            'status' => 'required|string|in:Active,Inactive',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'thumbnail_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['title', 'description', 'url', 'status']);

        if ($request->hasFile('main_image')) {
            if ($caseStudy->getRawOriginal('main_image')) {
                Storage::disk('s3')->delete($caseStudy->getRawOriginal('main_image'));
            }
            $data['main_image'] = $request->file('main_image')->store('case_studies', 's3');
        }

        if ($request->hasFile('thumbnail_image')) {
            if ($caseStudy->getRawOriginal('thumbnail_image')) {
                Storage::disk('s3')->delete($caseStudy->getRawOriginal('thumbnail_image'));
            }
            $data['thumbnail_image'] = $request->file('thumbnail_image')->store('case_studies/thumbnails', 's3');
        }

        $caseStudy->update($data);

        return redirect()->route('admin.case_studies.index')->with('success', 'Case study updated successfully');
    }

    public function destroy($id)
    {
        $caseStudy = CaseStudy::findOrFail($id);

        if ($caseStudy->getRawOriginal('main_image')) {
            Storage::disk('s3')->delete($caseStudy->getRawOriginal('main_image'));
        }
        if ($caseStudy->getRawOriginal('thumbnail_image')) {
            Storage::disk('s3')->delete($caseStudy->getRawOriginal('thumbnail_image'));
        }

        $caseStudy->delete();

        return redirect()->back()->with('success', 'Case study deleted successfully');
    }
}
