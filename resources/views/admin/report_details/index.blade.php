@extends('layouts.admin')

@section('header_title', 'Report Details List')

@section('content')
<div class="h-full bg-gray-800/40 rounded-3xl p-8 shadow-2xl border border-gray-700/50 backdrop-blur-sm relative overflow-y-auto w-full mx-auto max-w-7xl">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-medium text-white tracking-tight">Report Details List</h2>
        <a href="{{ route('admin.report_details.create') }}" class="bg-gradient-to-r from-teal-500 to-emerald-600 hover:from-teal-400 hover:to-emerald-500 text-white font-medium py-2 px-6 rounded-xl shadow-lg transition-all">
            Add Report Details
        </a>
    </div>

    <!-- Search Form -->
    <div class="mb-6 flex justify-end">
        <form method="GET" action="{{ route('admin.report_details.index') }}" class="relative w-full max-w-sm">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search report details..." class="w-full bg-gray-900/50 border border-gray-700 text-white pl-4 pr-10 py-2.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 transition-colors">
            <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </button>
        </form>
    </div>

    <div class="overflow-x-auto bg-gray-900/50 rounded-2xl border border-gray-800 shadow-inner">
        <table class="w-full text-left text-sm text-gray-400">
            <thead class="text-xs text-gray-500 uppercase bg-gray-800/50 border-b border-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-4 font-medium w-16">SR</th>
                    <th scope="col" class="px-6 py-4 font-medium">Report Category List Name</th>
                    <th scope="col" class="px-6 py-4 font-medium">Report Details Title</th>
                    <th scope="col" class="px-6 py-4 font-medium">Report Details Description</th>
                    <th scope="col" class="px-6 py-4 font-medium">Status</th>
                    <th scope="col" class="px-6 py-4 font-medium">Created At</th>
                    <th scope="col" class="px-6 py-4 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($details as $index => $detail)
                <tr class="border-b border-gray-800 last:border-0 hover:bg-gray-800/20 transition-colors">
                    <td class="px-6 py-4 text-gray-400">
                        {{ ($details->currentPage() - 1) * $details->perPage() + $loop->iteration }}
                    </td>
                    <td class="px-6 py-4 text-blue-400 font-medium whitespace-nowrap" title="{{ $detail->reportList->name ?? '' }}">
                        {{ \Illuminate\Support\Str::limit($detail->reportList->name ?? '—', 50) }}
                    </td>
                    <td class="px-6 py-4 text-gray-300 max-w-xs" title="{{ strip_tags($detail->title) }}">
                         {{ \Illuminate\Support\Str::limit(strip_tags($detail->title), 50) }}
                    </td>
                    <td class="px-6 py-4 text-gray-400 text-xs max-w-xs" title="{{ strip_tags($detail->description) }}">
                         {{ \Illuminate\Support\Str::limit(strip_tags($detail->description), 50) }}
                    </td>
                    <td class="px-6 py-4">
                        @if(strtolower($detail->status) === 'active' || $detail->status == 1)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border bg-emerald-500/10 text-emerald-400 border-emerald-500/20">
                                <span class="w-1.5 h-1.5 rounded-full mr-1.5 bg-emerald-400"></span> Active
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border bg-gray-500/10 text-gray-400 border-gray-500/20">
                                <span class="w-1.5 h-1.5 rounded-full mr-1.5 bg-gray-400"></span> Inactive
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $detail->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('admin.report_details.edit', $detail->id) }}" class="text-indigo-400 hover:text-indigo-300 transition-colors" title="Edit">
                                <svg class="w-5 h-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <button type="button" class="text-rose-400 hover:text-rose-300 transition-colors" title="Delete" onclick="openDeleteModal('{{ $detail->id }}', '{{ addslashes(strip_tags($detail->title)) }}')">
                                <svg class="w-5 h-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">No report details found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6 flex justify-end">
        {{ $details->links('pagination::tailwind') }}
    </div>
</div>

<!-- Delete Confirmation Modal (Moved outside the backdrop-filter div to fix fixed positioning) -->
<div id="deleteModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/80 backdrop-blur-sm transition-opacity" style="opacity: 0;">
    <div class="bg-gray-800 border border-gray-700 rounded-2xl shadow-2xl max-w-sm w-full overflow-hidden transform scale-95 transition-all duration-200" id="deleteModalPanel">
        <div class="p-6">
            <div class="flex items-center justify-center w-12 h-12 mx-auto bg-rose-500/10 rounded-full mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            
            <h3 class="text-lg font-medium text-gray-200 text-center mb-2">Delete Report Detail</h3>
            <p class="text-sm text-gray-400 text-center" id="deleteModalMessage">Are you sure you want to delete this report detail? This action cannot be undone.</p>
        </div>
        
        <form id="deleteModalForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <div class="flex border-t border-gray-700">
                <button 
                    type="button"
                    onclick="closeDeleteModal()"
                    class="flex-1 px-4 py-3 text-sm font-medium text-gray-400 hover:text-gray-200 hover:bg-gray-700/50 transition-colors border-r border-gray-700 outline-none"
                >
                    Cancel
                </button>
                <button 
                    type="submit"
                    class="flex-1 px-4 py-3 text-sm font-medium text-rose-500 hover:bg-rose-500/10 transition-colors outline-none"
                >
                    Delete
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openDeleteModal(reportId, reportName) {
        const modal = document.getElementById('deleteModal');
        const modalPanel = document.getElementById('deleteModalPanel');
        const message = document.getElementById('deleteModalMessage');
        const form = document.getElementById('deleteModalForm');
        
        // Update Content
        message.innerText = `Are you sure you want to delete this report detail? This action cannot be undone.`;
        
        // Build the delete route strictly based on the standard pattern using a placeholder
        const formAction = `{{ route('admin.report_details.destroy', ':id') }}`.replace(':id', reportId);
        form.action = formAction;
        
        // Show modal with animation
        modal.classList.remove('hidden');
        // Force reflow
        void modal.offsetWidth;
        modal.style.opacity = '1';
        modalPanel.classList.remove('scale-95');
        modalPanel.classList.add('scale-100');
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        const modalPanel = document.getElementById('deleteModalPanel');
        
        modal.style.opacity = '0';
        modalPanel.classList.remove('scale-100');
        modalPanel.classList.add('scale-95');
        
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200); // Matches transition duration
    }
</script>
@endsection
