@extends('layouts.admin')

@section('header_title', 'Edit Report')

@section('content')
<div class="h-full bg-gray-800/40 rounded-3xl p-8 shadow-2xl border border-gray-700/50 backdrop-blur-sm relative overflow-y-auto w-full  mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-medium text-white tracking-tight">Edit Report</h2>
        <a href="{{ route('admin.reports.index') }}" class="text-gray-400 hover:text-white transition-colors">
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

    <form method="POST" action="{{ route('admin.reports.update', $reportList->id) }}" class="space-y-6">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Select Report Category -->
            <div>
                <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">
                    Select Report Category <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <select
                        name="report_category_id"
                        required
                        class="w-full bg-gray-800/80 border border-gray-700 rounded-xl pl-4 pr-10 py-2.5 text-sm text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all appearance-none cursor-pointer"
                    >
                        <option value="" disabled {{ old('report_category_id', $reportList->report_category_id) ? '' : 'selected' }}>-- Select Category --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('report_category_id', $reportList->report_category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
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

            <!-- New Report Name -->
            <div>
                <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">
                    Report Name <span class="text-rose-500">*</span>
                </label>
                <textarea
                    name="name"
                    rows="3"
                    required
                    placeholder="Enter report name..."
                    class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all resize-y"
                >{{ old('name', $reportList->name) }}</textarea>
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">
                    Status <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <select
                        name="status"
                        required
                        class="w-full bg-gray-800/80 border border-gray-700 rounded-xl pl-4 pr-10 py-2.5 text-sm text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-all appearance-none cursor-pointer"
                    >
                        <option value="">---</option>
                        <option value="Active" {{ old('status', $reportList->status) == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ old('status', $reportList->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                        <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                        </svg>
                    </div>
                </div>
            </div>

        </div>

        <!-- Actions -->
        <div class="pt-4 border-t border-gray-700/50 mt-6">
            <div class="flex items-center">
                <button
                    type="submit"
                    class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-400 hover:to-indigo-500 text-white font-medium py-2.5 px-6 rounded-xl shadow-lg shadow-blue-500/20 transition-all active:scale-95 flex items-center justify-center"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    Update Report
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
