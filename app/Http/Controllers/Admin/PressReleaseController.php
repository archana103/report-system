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

        $sortBy = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'desc');

        $query->orderBy($sortBy, $sortDir);

        if ($request->has('export') && $request->export == 'true') {
            return response()->json($query->get());
        }

        $limit = $request->get('limit', 20);
        $data = $query->paginate($limit);

        return response()->json($data);
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

        return response()->json(['message' => 'Press release created successfully', 'data' => $pressRelease], 201);
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

        return response()->json(['message' => 'Press release updated successfully', 'data' => $pressRelease]);
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

        return response()->json(['message' => 'Press release deleted successfully']);
    }
}
