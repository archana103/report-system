@extends('layouts.admin')

@section('header_title', 'Create Press Release')

@section('content')
<div class="h-full bg-gray-800/40 rounded-3xl p-8 shadow-2xl border border-gray-700/50 backdrop-blur-sm relative overflow-y-auto w-full mx-auto">
    <div class="flex items-center justify-between mb-8 overflow-hidden rounded-2xl bg-gradient-to-r from-teal-600/10 to-transparent p-4 border-l-4 border-teal-500">
        <div>
            <h2 class="text-2xl font-bold text-white tracking-tight">Add New Press Release</h2>
            <p class="text-gray-400 text-sm mt-1">Create a new press release. This will automatically generate a blank detail page.</p>
        </div>
        <a href="{{ route('admin.press_releases.index') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-gray-800 hover:bg-gray-700 border border-gray-700 rounded-xl text-sm font-medium text-gray-300 hover:text-white shadow-sm transition-all focus:ring-2 focus:ring-gray-600 focus:outline-none">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to List
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

    <form method="POST" action="{{ route('admin.press_releases.store') }}" enctype="multipart/form-data" class="space-y-8 pb-12">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8 bg-gray-900/40 rounded-3xl border border-gray-800 shadow-2xl backdrop-blur-sm animate-in fade-in slide-in-from-bottom-4 duration-500">
            <div class="col-span-1 md:col-span-2">
                <label class="block text-sm font-semibold text-gray-300 mb-3 ml-1">Title <span class="text-rose-500">*</span></label>
                <input name="title" type="text" value="{{ old('title') }}" placeholder="Press Release Title..." required class="w-full bg-gray-800 border border-gray-700/50 rounded-xl px-4 py-3 text-sm text-gray-200 focus:ring-2 focus:ring-teal-500/50 focus:border-teal-500/50 transition-all shadow-inner" />
            </div>

            <div class="col-span-1">
                <label class="block text-sm font-semibold text-gray-300 mb-3 ml-1">URL <span class="text-rose-500">*</span></label>
                <input name="url" type="text" value="{{ old('url') }}" placeholder="press-release-url-slug" required class="w-full bg-gray-800 border border-gray-700/50 rounded-xl px-4 py-3 text-sm text-gray-200 focus:ring-2 focus:ring-teal-500/50 focus:border-teal-500/50 transition-all shadow-inner font-mono text-xs" />
            </div>
            
            <div class="col-span-1">
                <label class="block text-sm font-semibold text-gray-300 mb-3 ml-1">Status <span class="text-rose-500">*</span></label>
                <select name="status" required class="w-full bg-gray-800 border border-gray-700/50 rounded-xl px-4 py-3 text-sm text-gray-200 focus:ring-2 focus:ring-teal-500/50 focus:border-teal-500/50 transition-all shadow-inner">
                    <option value="Active" {{ old('status', 'Active') == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="col-span-1 md:col-span-2">
                <label class="block text-sm font-semibold text-gray-300 mb-3 ml-1">Short Description <span class="text-rose-500">*</span></label>
                <textarea name="description" rows="4" placeholder="Brief summary of the press release..." required class="w-full bg-gray-800 border border-gray-700/50 rounded-xl px-4 py-3 text-sm text-gray-200 focus:ring-2 focus:ring-teal-500/50 focus:border-teal-500/50 transition-all shadow-inner">{{ old('description') }}</textarea>
            </div>

            <div class="col-span-1">
                <label class="block text-sm font-semibold text-gray-300 mb-3 ml-1">Main Image</label>
                <div class="border-2 border-dashed border-gray-700 rounded-xl p-4 bg-gray-800/50 text-center hover:bg-gray-800 hover:border-gray-600 transition-all">
                    <input type="file" name="main_image" accept="image/*" class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-gray-700 file:text-gray-200 hover:file:bg-gray-600 transition-all cursor-pointer" />
                    <p class="text-xs text-gray-500 mt-2">Recommended: Main display image</p>
                </div>
            </div>
            
            <div class="col-span-1">
                <label class="block text-sm font-semibold text-gray-300 mb-3 ml-1">Thumbnail Image</label>
                <div class="border-2 border-dashed border-gray-700 rounded-xl p-4 bg-gray-800/50 text-center hover:bg-gray-800 hover:border-gray-600 transition-all">
                    <input type="file" name="thumbnail_image" accept="image/*" class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-gray-700 file:text-gray-200 hover:file:bg-gray-600 transition-all cursor-pointer" />
                    <p class="text-xs text-gray-500 mt-2">Recommended: Grid listing thumbnail image</p>
                </div>
            </div>
            
            <div class="col-span-1 md:col-span-2 pt-4 flex items-center justify-end space-x-4">
                <a href="{{ route('admin.press_releases.index') }}" class="px-8 py-3 rounded-xl text-sm font-medium text-gray-400 hover:text-white transition-all">Cancel</a>
                <button type="submit" class="px-10 py-3 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-500 hover:to-emerald-500 shadow-xl shadow-teal-500/20 transition-all active:scale-95">
                    Save Press Release
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
