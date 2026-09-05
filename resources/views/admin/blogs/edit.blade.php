@extends('layouts.admin')

@section('header_title', 'Edit Blog')

@section('content')
<div class="h-full bg-gray-800/40 rounded-3xl p-8 shadow-2xl border border-gray-700/50 backdrop-blur-sm relative overflow-y-auto w-full mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-medium text-white tracking-tight">Edit Blog: {{ $blog->title }}</h2>
        <a href="{{ route('admin.blogs.index') }}" class="text-gray-400 hover:text-white transition-colors">
            &larr; Back to List
        </a>
    </div>

    @if($errors->any())
        <div class="mb-6 bg-rose-500/10 border border-rose-500/30 text-rose-400 p-4 rounded-xl flex items-center gap-3">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <div class="flex flex-col">
              @foreach ($errors->all() as $error)
                <span class="font-medium">{{ $error }}</span>
              @endforeach
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.blogs.update', $blog->id) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Row 1 -->
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5 ml-1">Blog Title <span class="text-rose-500">*</span></label>
                <input name="title" type="text" value="{{ old('title', $blog->title) }}" required class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500/50 focus:border-teal-500/50 transition-all" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5 ml-1">Slug URL</label>
                <input name="url" type="text" value="{{ old('url', $blog->url) }}" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500/50 focus:border-teal-500/50 transition-all" />
            </div>

            <!-- Row 2 -->
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5 ml-1">Author Name</label>
                <input name="author_name" type="text" value="{{ old('author_name', $blog->author_name) }}" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500/50 focus:border-teal-500/50 transition-all" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5 ml-1">Blog Image</label>
                <input name="image" type="file" accept="image/*" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500/50 transition-all file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:bg-gray-700 file:text-gray-200 hover:file:bg-gray-600" />
                <p class="text-[11px] text-gray-500 mt-1.5 ml-1">Leave empty to keep current image. Allowed formats: JPG, PNG, GIF, SVG</p>
                @if($blog->image)
                    <div class="mt-3 ml-1">
                        <span class="block text-xs text-gray-400 mb-1">Current Image:</span>
                        <img src="{{ $blog->image }}" alt="Current Blog Image" class="h-16 w-auto rounded border border-gray-700">
                    </div>
                @endif
            </div>
        </div>

        <!-- Row 3: Description -->
        <div>
            <label class="block text-sm font-medium text-gray-400 mb-1.5 ml-1">Description</label>
            <div class="rounded-xl overflow-hidden shadow-sm border border-gray-700 bg-gray-800/50 transition-all">
                <textarea name="description" class="w-full bg-transparent p-4 text-white focus:outline-none min-h-[160px]">{{ old('description', $blog->description) }}</textarea>
            </div>
        </div>

        <div class="pt-4 border-t border-gray-700/50">
            <div class="flex items-center">
                <button type="submit" class="bg-gradient-to-r from-teal-500 to-emerald-600 hover:from-teal-400 hover:to-emerald-500 text-white font-medium py-2.5 px-8 rounded-xl shadow-lg shadow-teal-500/20 transition-all active:scale-95 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    Update Blog
                </button>
            </div>
        </div>
    </form>
</div>

@endsection
