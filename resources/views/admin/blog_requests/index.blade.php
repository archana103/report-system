@extends('layouts.admin')

@section('header_title', 'Blog Sample Requests')

@section('content')
<div class="h-full bg-gray-800/40 rounded-3xl p-8 shadow-2xl border border-gray-700/50 backdrop-blur-sm relative overflow-y-auto">
    <div class="absolute -top-10 -right-10 w-40 h-40 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="flex justify-between items-center mb-6 relative z-10">
        <h2 class="text-2xl font-medium text-white tracking-tight">Blog Sample Requests</h2>
    </div>

    <!-- Search Form -->
    <div class="mb-6 flex justify-end relative z-10">
        <form method="GET" action="{{ route('admin.blog_requests.index') }}" class="relative w-full max-w-sm">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search requests..." class="w-full bg-gray-900/50 border border-gray-700 text-white pl-4 pr-10 py-2.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors">
            <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </button>
        </form>
    </div>

    <!-- Data Table -->
    <div class="overflow-x-auto bg-gray-900/50 rounded-2xl border border-gray-800 shadow-inner relative z-10">
        <table class="w-full text-left text-sm text-gray-400">
            <thead class="text-xs text-gray-500 uppercase bg-gray-800/50 border-b border-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-4 font-medium">Name</th>
                    <th scope="col" class="px-6 py-4 font-medium">Email</th>
                    <th scope="col" class="px-6 py-4 font-medium">Phone</th>
                    <th scope="col" class="px-6 py-4 font-medium">Company</th>
                    <th scope="col" class="px-6 py-4 font-medium">Country</th>
                    <th scope="col" class="px-6 py-4 font-medium">Requested Blog</th>
                    <th scope="col" class="px-6 py-4 font-medium">Date</th>
                    <th scope="col" class="px-6 py-4 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($requests as $req)
                <tr class="border-b border-gray-800 last:border-0 hover:bg-gray-800/20 transition-colors">
                    <td class="px-6 py-4 font-medium text-gray-200 whitespace-nowrap">{{ $req->full_name ?? '—' }}</td>
                    <td class="px-6 py-4">{{ $req->email ?? '—' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $req->phone ?? '—' }}</td>
                    <td class="px-6 py-4">{{ Str::limit($req->company_name ?? '—', 20) }}</td>
                    <td class="px-6 py-4">{{ $req->country ?? '—' }}</td>
                    <td class="px-6 py-4 font-medium">
                        @if($req->blog)
                            <span class="text-indigo-300 line-clamp-1" title="{{ $req->blog->title }}">{{ Str::limit($req->blog->title, 30) }}</span>
                        @else
                            <span class="text-gray-500 italic">Deleted Blog</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $req->created_at->format('M d, Y, h:i A') }}</td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-3">
                            <button type="button" class="text-blue-400 hover:text-blue-300 transition-colors" title="View Details" onclick="viewRequest({{ json_encode($req) }}, {{ json_encode($req->blog ? $req->blog->title : null) }})">
                                <svg class="w-5 h-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            </button>
                            <button type="button" class="text-rose-400 hover:text-rose-300 transition-colors" title="Delete" onclick="openDeleteModal('{{ $req->id }}', '{{ addslashes($req->full_name) }}')">
                                <svg class="w-5 h-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-8 text-center text-gray-500">No blog requests found.</td>
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
            
            <h3 class="text-lg font-medium text-gray-200 text-center mb-2">Delete Blog Request</h3>
            <p class="text-sm text-gray-400 text-center" id="deleteModalMessage">Are you sure you want to delete this blog request? This action cannot be undone.</p>
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
            <h3 class="text-lg font-medium text-gray-200">Blog Request Details</h3>
            <button onclick="closeViewModal()" class="text-gray-400 hover:text-gray-200 transition-colors cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        
        <div class="p-6 overflow-y-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold tracking-wider mb-1">Name</p>
                    <p class="text-gray-200 font-medium" id="v-name">—</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold tracking-wider mb-1">Email</p>
                    <p class="text-gray-200 font-medium" id="v-email">—</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold tracking-wider mb-1">Phone</p>
                    <p class="text-gray-200 font-medium" id="v-phone">—</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold tracking-wider mb-1">Country</p>
                    <p class="text-gray-200 font-medium" id="v-country">—</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold tracking-wider mb-1">Company Name</p>
                    <p class="text-gray-200 font-medium" id="v-company">—</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold tracking-wider mb-1">Submitted At</p>
                    <p class="text-gray-400 text-sm" id="v-date">—</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-xs text-gray-500 uppercase font-semibold tracking-wider mb-1">Requested Blog Title</p>
                    <div class="bg-gray-900/50 p-4 rounded-xl border border-gray-700/50 mt-2">
                        <p class="text-indigo-300 font-semibold text-sm leading-relaxed" id="v-blog-title"></p>
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
        
        message.innerText = `Are you sure you want to delete the blog request from '${name}'? This action cannot be undone.`;
        form.action = `{{ route('admin.blog_requests.destroy', ':id') }}`.replace(':id', id);
        
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
    
    function viewRequest(req, blogTitle) {
        document.getElementById('v-name').innerText = req.full_name || '—';
        document.getElementById('v-email').innerText = req.email || '—';
        document.getElementById('v-phone').innerText = req.phone || '—';
        document.getElementById('v-company').innerText = req.company_name || '—';
        document.getElementById('v-country').innerText = req.country || '—';
        
        let d = new Date(req.created_at);
        document.getElementById('v-date').innerText = !isNaN(d.getTime()) ? d.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' }) : '—';
        
        const blogEl = document.getElementById('v-blog-title');
        if (blogTitle) {
            blogEl.innerText = blogTitle;
            blogEl.className = "text-indigo-300 font-semibold text-sm leading-relaxed";
        } else {
            blogEl.innerText = "Deleted Blog";
            blogEl.className = "text-gray-500 italic text-sm";
        }
        
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
