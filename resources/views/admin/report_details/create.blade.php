@extends('layouts.admin')

@section('header_title', 'Add Report Details')

@section('content')
<div class="h-full bg-gray-800/40 rounded-3xl p-8 shadow-2xl border border-gray-700/50 backdrop-blur-sm relative overflow-y-auto w-full mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-medium text-white tracking-tight">Add Report Details</h2>
        <a href="{{ route('admin.report_details.index') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-gray-800 hover:bg-gray-700 border border-gray-700 rounded-xl text-sm font-medium text-gray-300 hover:text-white shadow-sm transition-all focus:ring-2 focus:ring-gray-600 focus:outline-none">
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

    <form method="POST" action="{{ route('admin.report_details.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        <!-- Row 1: Select Report & Title -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">
                    Select Report <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <select
                        name="report_list_id"
                        required
                        class="w-full bg-gray-800/80 border border-gray-700 rounded-xl pl-4 pr-10 py-2.5 text-sm text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all appearance-none cursor-pointer"
                    >
                        <option value="" disabled {{ old('report_list_id') ? '' : 'selected' }}>---</option>
                        @foreach($reportLists as $list)
                            <option value="{{ $list->id }}" {{ old('report_list_id') == $list->id ? 'selected' : '' }}>
                                {{ $list->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                        <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                        </svg>
                    </div>
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">
                    Report Details Title
                </label>
                <textarea
                    name="title"
                    rows="2"
                    class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all resize-y"
                >{{ old('title') }}</textarea>
            </div>
        </div>

        <!-- Row 2: Description & Category List Download -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">
                    Report Details Description
                </label>
                <textarea
                    name="detail_description"
                    rows="3"
                    class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all resize-y"
                >{{ old('detail_description') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">
                    Report Category List Download
                </label>
                <textarea
                    name="category_list_download"
                    rows="3"
                    class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all resize-y"
                >{{ old('category_list_download') }}</textarea>
            </div>
        </div>

        <!-- Row 3: Download Text & Image -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">
                    Report Details Download Text
                </label>
                <textarea
                    name="download_text"
                    rows="3"
                    class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all resize-y"
                >{{ old('download_text') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Report Details Image</label>
                <div class="flex items-center justify-center w-full">
                    <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-xl cursor-pointer bg-gray-900/50 border-gray-700 hover:bg-gray-800/50 hover:border-gray-500 transition-colors">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-3 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                            </svg>
                            <p class="mb-2 text-sm text-gray-400"><span class="font-semibold text-blue-400">Click to upload</span> or drag and drop</p>
                            <p class="text-xs text-gray-500">JPG, JPEG, PNG, GIF (Max size: 2MB)</p>
                        </div>
                        <input type="file" name="image" class="hidden" accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml" onchange="document.getElementById('file-chosen-status').innerText = this.files[0] ? this.files[0].name : 'No file chosen';"/>
                    </label>
                </div>
                <p id="file-chosen-status" class="text-xs text-emerald-400 mt-2 ml-1"></p>
            </div>
        </div>

        <!-- Row 4: Status -->
        <div class="w-full md:w-1/2">
            <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">
                Status <span class="text-rose-500">*</span>
            </label>
            <div class="relative">
                <select
                    name="status"
                    required
                    class="w-full bg-gray-800/80 border border-gray-700 rounded-xl pl-4 pr-10 py-2.5 text-sm text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all appearance-none cursor-pointer"
                >
                    <option value="" disabled {{ old('status') ? '' : 'selected' }}>---</option>
                    <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                    <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                    </svg>
                </div>
            </div>
        </div>


        <!-- Actions -->
        <div class="pt-6 border-t border-gray-700/50 mt-6 md:col-span-2">
            <div class="flex items-center">
                <button
                    type="submit"
                    class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-400 hover:to-indigo-500 text-white font-medium py-2.5 px-8 rounded-xl shadow-lg shadow-blue-500/20 transition-all active:scale-95 flex items-center justify-center"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    Add Report Detail
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
