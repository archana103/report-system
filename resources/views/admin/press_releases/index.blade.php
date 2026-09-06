@extends('layouts.admin')

@section('header_title', 'Press Releases Management')

@section('content')
<div class="h-full bg-gray-800/40 rounded-3xl p-8 shadow-2xl border border-gray-700/50 backdrop-blur-sm relative overflow-y-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-medium text-white tracking-tight">Press Releases List</h2>
        <a href="{{ route('admin.press_releases.create') }}" class="bg-gradient-to-r from-teal-500 to-emerald-600 hover:from-teal-400 hover:to-emerald-500 text-white font-medium py-2 px-6 rounded-xl shadow-lg transition-all">
            Add New Press Release
        </a>
    </div>

    <!-- Search Form -->
    <div class="mb-6 flex justify-end">
        <form method="GET" action="{{ route('admin.press_releases.index') }}" class="relative w-full max-w-sm">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search press releases..." class="w-full bg-gray-900/50 border border-gray-700 text-white pl-4 pr-10 py-2.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 transition-colors">
            <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </button>
        </form>
    </div>

    <!-- Data Table -->
    <div class="overflow-x-auto bg-gray-900/50 rounded-2xl border border-gray-800 shadow-inner">
        <table class="w-full text-left text-sm text-gray-400">
            <thead class="text-[10px] text-gray-400 uppercase font-bold tracking-wider bg-[#1B2230] border-b border-gray-700/50">
                <tr>
                    <th scope="col" class="px-5 py-4">SR</th>
                    <th scope="col" class="px-5 py-4 min-w-[200px]">TITLE</th>
                    <th scope="col" class="px-5 py-4 min-w-[300px]">DESCRIPTION</th>
                    <th scope="col" class="px-5 py-4 min-w-[150px]">URL</th>
                    <th scope="col" class="px-5 py-4">IMAGE</th>
                    <th scope="col" class="px-5 py-4">STATUS</th>
                    <th scope="col" class="px-5 py-4">DATE</th>
                    <th scope="col" class="px-5 py-4 text-center">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pressReleases as $index => $pr)
                <tr class="border-b border-gray-700/50 last:border-0 hover:bg-[#1B2230]/50 transition-colors bg-[#151B26]">
                    <td class="px-5 py-4 text-gray-300 font-medium whitespace-nowrap">{{ $pressReleases->firstItem() + $index }}</td>
                    <td class="px-5 py-4 font-medium text-gray-200">
                        {{ $pr->title }}
                    </td>
                    <td class="px-5 py-4 text-gray-400 text-sm">
                        {{ Str::limit($pr->description, 60) }}
                    </td>
                    <td class="px-5 py-4 text-gray-400 text-sm break-all font-mono">
                        {{ $pr->url }}
                    </td>
                    <td class="px-5 py-4">
                        @if($pr->main_image || $pr->thumbnail_image)
                            <div class="h-12 w-16 bg-gray-800 rounded overflow-hidden border border-gray-700 shadow-sm flex items-center justify-center">
                                <img src="{{ $pr->main_image ?? $pr->thumbnail_image }}" alt="PR Image" class="w-full h-full object-cover">
                            </div>
                        @else
                            <div class="h-12 w-16 bg-gray-800 rounded border border-gray-700 flex items-center justify-center text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                    </td>
                    <td class="px-5 py-4">
                        @if(strtolower($pr->status) === 'active')
                            <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-[11px] font-bold bg-[#044c3c] text-emerald-400 border border-emerald-500/20 shadow-inner">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                Active
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-[11px] font-bold bg-[#4c1d1a] text-rose-400 border border-rose-500/20 shadow-inner">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                                Inactive
                            </span>
                        @endif
                    </td>
                    <td class="px-5 py-4 text-sm text-gray-400 whitespace-nowrap">
                        {{ $pr->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-5 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.press_releases.edit', $pr->id) }}" class="flex items-center justify-center w-8 h-8 rounded bg-indigo-500/10 hover:bg-indigo-500/20 text-indigo-400 hover:text-indigo-300 transition-colors border border-indigo-500/20 shadow-sm" title="Edit">
                                <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </a>
                            <button type="button" class="flex items-center justify-center w-8 h-8 rounded bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 hover:text-rose-300 transition-colors border border-rose-500/20 shadow-sm" title="Delete" onclick="openDeleteModal('{{ $pr->id }}', '{{ addslashes($pr->title) }}')">
                                <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-8 text-center text-gray-500">No press releases found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6 flex justify-end relative z-10">
        {{ $pressReleases->links('pagination::tailwind') }}
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
            
            <h3 class="text-lg font-medium text-gray-200 text-center mb-2">Delete Press Release</h3>
            <p class="text-sm text-gray-400 text-center" id="deleteModalMessage">Are you sure you want to delete this press release? This action cannot be undone.</p>
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

<script>
    function openDeleteModal(id, title) {
        const modal = document.getElementById('deleteModal');
        const modalPanel = document.getElementById('deleteModalPanel');
        const message = document.getElementById('deleteModalMessage');
        const form = document.getElementById('deleteModalForm');
        
        message.innerText = `Are you sure you want to delete '${title}'? This action cannot be undone.`;
        form.action = `{{ route('admin.press_releases.destroy', ':id') }}`.replace(':id', id);
        
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
</script>
@endsection
