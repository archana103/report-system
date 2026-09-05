<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PressRelease;
use Illuminate\Support\Facades\Storage;

class PressReleaseController extends Controller
{
    public function index(Request $request)
    {
        $query = PressRelease::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('url', 'like', '%' . $search . '%');
            });
        }

        $pressReleases = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.press_releases.index', compact('pressReleases'));
    }

    public function create()
    {
        return view('admin.press_releases.create');
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
            $data['main_image'] = $request->file('main_image')->store('press_releases', 's3');
        }

        if ($request->hasFile('thumbnail_image')) {
            $data['thumbnail_image'] = $request->file('thumbnail_image')->store('press_releases/thumbnails', 's3');
        }

        $pressRelease = PressRelease::create($data);
        
        \App\Models\PressReleaseDetail::create([
            'press_release_id' => $pressRelease->id
        ]);

        return redirect()->route('admin.press_releases.index')->with('success', 'Press release created successfully');
    }

    public function edit($id)
    {
        $pressRelease = PressRelease::findOrFail($id);
        return view('admin.press_releases.edit', compact('pressRelease'));
    }

    public function update(Request $request, $id)
    {
        $pressRelease = PressRelease::findOrFail($id);

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
            if ($pressRelease->getRawOriginal('main_image')) {
                Storage::disk('s3')->delete($pressRelease->getRawOriginal('main_image'));
            }
            $data['main_image'] = $request->file('main_image')->store('press_releases', 's3');
        }

        if ($request->hasFile('thumbnail_image')) {
            if ($pressRelease->getRawOriginal('thumbnail_image')) {
                Storage::disk('s3')->delete($pressRelease->getRawOriginal('thumbnail_image'));
            }
            $data['thumbnail_image'] = $request->file('thumbnail_image')->store('press_releases/thumbnails', 's3');
        }

        $pressRelease->update($data);

        return redirect()->route('admin.press_releases.index')->with('success', 'Press release updated successfully');
    }

    public function destroy($id)
    {
        $pressRelease = PressRelease::findOrFail($id);

        if ($pressRelease->getRawOriginal('main_image')) {
            Storage::disk('s3')->delete($pressRelease->getRawOriginal('main_image'));
        }
        if ($pressRelease->getRawOriginal('thumbnail_image')) {
            Storage::disk('s3')->delete($pressRelease->getRawOriginal('thumbnail_image'));
        }

        $pressRelease->delete();

        return redirect()->back()->with('success', 'Press release deleted successfully');
    }
}
