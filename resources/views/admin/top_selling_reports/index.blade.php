@extends('layouts.admin')

@section('header_title', 'Top Selling Reports')

@section('content')
<div class="h-full bg-gray-800/40 rounded-3xl p-6 lg:p-8 shadow-2xl border border-gray-700/50 backdrop-blur-sm relative flex flex-col min-h-0 w-full overflow-hidden">


    <!-- Add New Top Selling Report Form -->
    <div class="bg-gray-900/50 border border-gray-700/50 rounded-2xl p-5 mb-6 shrink-0 shadow-inner">
        <form action="{{ route('admin.top_selling_reports.store') }}" method="POST" class="flex flex-col sm:flex-row gap-4 items-end">
            @csrf
            <div class="flex-grow w-full">
                <!-- <label class="block text-sm font-medium text-gray-400 mb-2 ml-1">Select Report to Feature</label> -->
                <div class="relative">
                    <select name="report_detail_id" required class="w-full bg-gray-800/80 border border-gray-700 rounded-xl pl-4 pr-10 py-3 text-sm text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500/50 focus:border-teal-500/50 transition-all appearance-none cursor-pointer">
                        <option value="" disabled selected>--- Search and Select a Report ---</option>
                        @foreach($availableReports as $r)
                            <option value="{{ $r->id }}">{{ $r->title }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                        <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                    </div>
                </div>
            </div>
            <button type="submit" class="bg-gradient-to-r from-teal-500 to-emerald-600 hover:from-teal-400 hover:to-emerald-500 text-white font-medium py-3 px-8 rounded-xl shadow-lg shadow-teal-500/20 transition-all active:scale-95 whitespace-nowrap flex items-center justify-center w-full sm:w-auto h-[46px]">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Add to List
            </button>
        </form>
    </div>

    <!-- Table -->
    <div class="flex-1 overflow-auto rounded-xl border border-gray-700/50 bg-gray-900/30 w-full">
        @if($reports->isEmpty())
            <div class="flex flex-col items-center justify-center p-12 text-gray-400">
                <svg class="w-16 h-16 mb-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                <p class="text-lg">No Top Selling Reports added yet.</p>
                <p class="text-sm mt-1">Select a report from above to feature it.</p>
            </div>
        @else
            <div class="inline-block min-w-full align-middle">
                <table class="min-w-full divide-y divide-gray-700/50">
                    <thead class="bg-gray-800/80 sticky top-0 backdrop-blur-sm z-10">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Report Title</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider w-40">Added On</th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-300 uppercase tracking-wider w-32">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700/50 bg-transparent">
                        @foreach($reports as $report)
                        <tr class="hover:bg-gray-700/20 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-200">
                                    {{ $report->reportDetail ? $report->reportDetail->title : 'Unknown' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                {{ $report->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button type="button" onclick="openDeleteModal('{{ $report->id }}', '{{ addslashes($report->reportDetail ? $report->reportDetail->title : 'Unknown') }}')" class="text-rose-400 hover:text-rose-300 bg-rose-400/10 hover:bg-rose-400/20 p-2 rounded-lg transition-all inline-block" title="Remove">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
    
    @if($reports->hasPages())
        <div class="mt-6 shrink-0">
            {{ $reports->links('pagination::tailwind') }}
        </div>
    @endif
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
            
            <h3 class="text-lg font-medium text-gray-200 text-center mb-2">Remove Top Selling Report</h3>
            <p class="text-sm text-gray-400 text-center" id="deleteModalMessage">Are you sure you want to remove this report from the top selling list? This will NOT delete the report detail itself.</p>
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
        message.innerText = `Are you sure you want to remove '${reportName}' from the top selling list? This will NOT delete the report detail itself.`;
        
        // Build the delete route literally
        const formAction = `{{ url('/admin/top-selling-reports') }}/${reportId}`;
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
