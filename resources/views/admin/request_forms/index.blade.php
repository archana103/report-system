@extends('layouts.admin')

@section('header_title', 'General Request Forms')

@section('content')
<div class="h-full bg-gray-800/40 rounded-3xl p-8 shadow-2xl border border-gray-700/50 backdrop-blur-sm relative overflow-y-auto">
    <div class="absolute -top-10 -right-10 w-40 h-40 bg-purple-500/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 relative z-10 gap-4">
        <div>
            <h2 class="text-2xl font-medium text-white tracking-tight">Request Forms List</h2>
            <p class="text-gray-400 text-sm mt-1">Manage general inquiry request forms.</p>
        </div>

        <!-- Search Form -->
        <div class="w-full md:max-w-sm">
            <form method="GET" action="{{ route('admin.request_forms.index') }}" class="relative w-full">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search requests..." class="w-full bg-gray-900/50 border border-gray-700 text-white pl-4 pr-10 py-2.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 transition-colors shadow-inner">
                <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
            </form>
        </div>
    </div>

    <!-- Data Table -->
    <div class="overflow-x-auto bg-gray-900/50 rounded-2xl border border-gray-800 shadow-inner relative z-10">
        <table class="w-full text-left text-sm text-gray-400">
            <thead class="text-xs text-gray-500 uppercase bg-gray-800/50 border-b border-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-4 font-medium">Name</th>
                    <th scope="col" class="px-6 py-4 font-medium">Email</th>
                    <th scope="col" class="px-6 py-4 font-medium">Phone</th>
                    <th scope="col" class="px-6 py-4 font-medium">Report</th>
                    <th scope="col" class="px-6 py-4 font-medium">Subject / Message</th>
                    <th scope="col" class="px-6 py-4 font-medium">Submitted At</th>
                    <th scope="col" class="px-6 py-4 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($requests as $req)
                <tr class="border-b border-gray-800 last:border-0 hover:bg-gray-800/20 transition-colors">
                    <td class="px-6 py-4 font-medium text-gray-200 whitespace-nowrap">{{ $req->name ?? '—' }}</td>
                    <td class="px-6 py-4">{{ $req->email ?? '—' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $req->phone ?? '—' }}</td>
                    <td class="px-6 py-4">
                        <div class="max-w-xs truncate text-purple-200" title="{{ $req->report_name }}">
                            {{ $req->report_name ? Str::limit($req->report_name, 40) : '—' }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="max-w-xs truncate text-purple-200" title="{{ $req->subject }}">
                            {{ $req->subject ? Str::limit($req->subject, 50) : '—' }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $req->created_at->format('M d, Y, h:i A') }}</td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-3">
                            <button type="button" class="text-purple-400 hover:text-purple-300 transition-colors" title="View Details" onclick="viewRequest({{ json_encode($req) }})">
                                <svg class="w-5 h-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            </button>
                            <button type="button" class="text-rose-400 hover:text-rose-300 transition-colors" title="Delete" onclick="openDeleteModal('{{ $req->id }}', '{{ addslashes($req->name) }}')">
                                <svg class="w-5 h-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">No request forms found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6 flex justify-end relative z-10">
        {{ $requests->links('pagination::tailwind') }}
    </div>

</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/80 backdrop-blur-sm transition-opacity" style="opacity: 0;">
    <div class="bg-gray-800 border border-gray-700 rounded-2xl shadow-2xl max-w-sm w-full overflow-hidden transform scale-95 transition-all duration-200" id="deleteModalPanel">
        <div class="p-6">
            <div class="flex items-center justify-center w-12 h-12 mx-auto bg-rose-500/10 rounded-full mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            
            <h3 class="text-lg font-medium text-gray-200 text-center mb-2">Delete Request Form</h3>
            <p class="text-sm text-gray-400 text-center" id="deleteModalMessage">Are you sure you want to delete this request? This action cannot be undone.</p>
        </div>
        
        <form id="deleteModalForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <div class="flex border-t border-gray-700">
                <button type="button" onclick="closeDeleteModal()" class="flex-1 px-4 py-3 text-sm font-medium text-gray-400 hover:text-gray-200 hover:bg-gray-700/50 transition-colors border-r border-gray-700 outline-none">
                    Cancel
                </button>
                <button type="submit" class="flex-1 px-4 py-3 text-sm font-medium text-rose-500 hover:bg-rose-500/10 transition-colors outline-none">
                    Delete
                </button>
            </div>
        </form>
    </div>
</div>

<!-- View Details Modal -->
<div id="viewModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm transition-opacity" style="opacity: 0;">
    <div class="bg-gray-800 border border-gray-700 rounded-2xl shadow-2xl max-w-2xl w-full overflow-hidden transform scale-95 transition-all duration-200 flex flex-col max-h-[90vh]" id="viewModalPanel">
        <div class="px-6 py-4 border-b border-gray-700 flex justify-between items-center bg-gray-900/50">
            <h3 class="text-lg font-medium text-gray-200">Request Form Details</h3>
            <button onclick="closeViewModal()" class="text-gray-400 hover:text-gray-200 transition-colors cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        
        <div class="p-6 overflow-y-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-800">
                <div>
                    <p class="text-[10px] text-gray-500 uppercase font-bold tracking-wider mb-1">Name</p>
                    <p class="text-gray-200 font-medium" id="v-name">—</p>
                </div>
                <div>
                    <p class="text-[10px] text-gray-500 uppercase font-bold tracking-wider mb-1">Email</p>
                    <p class="text-gray-200 font-medium">
                        <a href="#" id="v-email-link" class="text-purple-400 hover:underline">
                            <span id="v-email">—</span>
                        </a>
                    </p>
                </div>
                <div>
                    <p class="text-[10px] text-gray-500 uppercase font-bold tracking-wider mb-1">Phone</p>
                    <p class="text-gray-200 font-medium">
                        <a href="#" id="v-phone-link" class="text-purple-400 hover:underline">
                            <span id="v-phone">—</span>
                        </a>
                    </p>
                </div>
                <div>
                    <p class="text-[10px] text-gray-500 uppercase font-bold tracking-wider mb-1">Submitted At</p>
                    <p class="text-gray-400 text-sm" id="v-date">—</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-[10px] text-gray-500 uppercase font-bold tracking-wider mb-1">Report Name</p>
                    <p class="text-gray-200 font-medium" id="v-report">—</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-[10px] text-gray-500 uppercase font-bold tracking-wider mb-2">Subject / Message</p>
                    <div class="bg-gray-900/50 p-5 rounded-xl border border-gray-700/50">
                        <p class="text-gray-300 text-sm leading-relaxed whitespace-pre-wrap" id="v-message">—</p>
                    </div>
                </div>
                <div class="md:col-span-2">
                    <p class="text-[10px] text-gray-500 uppercase font-bold tracking-wider mb-2">Specific Requirements</p>
                    <div class="bg-gray-900/50 p-5 rounded-xl border border-gray-700/50">
                        <p class="text-gray-300 text-sm leading-relaxed whitespace-pre-wrap" id="v-requirements">—</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-700 flex justify-end bg-gray-900/50">
            <button onclick="closeViewModal()" class="px-5 py-2.5 text-sm font-medium text-gray-300 bg-gray-800 hover:bg-gray-700 rounded-lg transition-colors border border-gray-600">
                Close
            </button>
        </div>
    </div>
</div>

<script>
    function openDeleteModal(id, name) {
        const modal = document.getElementById('deleteModal');
        const modalPanel = document.getElementById('deleteModalPanel');
        const message = document.getElementById('deleteModalMessage');
        const form = document.getElementById('deleteModalForm');
        
        message.innerText = `Are you sure you want to delete the request from '${name}'? This action cannot be undone.`;
        form.action = `{{ route('admin.request_forms.destroy', ':id') }}`.replace(':id', id);
        
        modal.classList.remove('hidden');
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
        setTimeout(() => modal.classList.add('hidden'), 200);
    }
    
    function viewRequest(req) {
        document.getElementById('v-name').innerText = req.name || '—';
        
        let emailEl = document.getElementById('v-email');
        let emailLink = document.getElementById('v-email-link');
        emailEl.innerText = req.email || '—';
        if(req.email) {
            emailLink.href = 'mailto:' + req.email;
        } else {
            emailLink.href = '#';
        }
        
        let phoneEl = document.getElementById('v-phone');
        let phoneLink = document.getElementById('v-phone-link');
        phoneEl.innerText = req.phone || '—';
        if(req.phone) {
            phoneLink.href = 'tel:' + req.phone;
        } else {
            phoneLink.href = '#';
        }

        document.getElementById('v-report').innerText = req.report_name || '—';

        document.getElementById('v-message').innerText = req.subject || 'No message provided.';
        document.getElementById('v-requirements').innerText = req.specific_research_requirement || 'No specific requirements provided.';
        
        let d = new Date(req.created_at);
        document.getElementById('v-date').innerText = !isNaN(d.getTime()) ? d.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' }) : '—';
        
        const modal = document.getElementById('viewModal');
        const modalPanel = document.getElementById('viewModalPanel');
        
        modal.classList.remove('hidden');
        void modal.offsetWidth;
        modal.style.opacity = '1';
        modalPanel.classList.remove('scale-95');
        modalPanel.classList.add('scale-100');
    }
    
    function closeViewModal() {
        const modal = document.getElementById('viewModal');
        const modalPanel = document.getElementById('viewModalPanel');
        
        modal.style.opacity = '0';
        modalPanel.classList.remove('scale-100');
        modalPanel.classList.add('scale-95');
        setTimeout(() => modal.classList.add('hidden'), 200);
    }
</script>
@endsection
