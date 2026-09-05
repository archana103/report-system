@extends('layouts.admin')

@section('header_title', 'Page SEO Management')

@section('content')
<div class="h-full bg-gray-800/40 rounded-3xl p-8 shadow-2xl border border-gray-700/50 backdrop-blur-sm relative overflow-y-auto w-full mx-auto">
    <div class="flex items-center justify-between mb-8 overflow-hidden rounded-2xl bg-gradient-to-r from-blue-600/10 to-transparent p-4 border-l-4 border-blue-500">
        <div>
            <h2 class="text-2xl font-bold text-white tracking-tight">Page SEO Settings</h2>
            <p class="text-gray-400 text-sm mt-1">Manage schema tags and raw SEO headers for custom URL paths.</p>
        </div>
        <button onclick="openFormModal()" class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-400 hover:to-indigo-500 text-white font-medium py-2 px-6 rounded-xl shadow-lg transition-all">
            Add New SEO Path
        </button>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 p-4 rounded-xl flex items-center gap-3">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif
    
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

    <!-- Search Form -->
    <div class="mb-6 flex justify-end">
        <form method="GET" action="{{ route('admin.page_seo.index') }}" class="relative w-full max-w-sm">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search URL paths..." class="w-full bg-gray-900/50 border border-gray-700/50 text-white pl-4 pr-10 py-2.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors shadow-inner">
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
                    <th scope="col" class="px-5 py-4">URL PATH</th>
                    <th scope="col" class="px-5 py-4">HAS SCHEMA</th>
                    <th scope="col" class="px-5 py-4">CREATED AT</th>
                    <th scope="col" class="px-5 py-4 text-center">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pageSeos as $index => $seo)
                <tr class="border-b border-gray-700/50 last:border-0 hover:bg-[#1B2230]/50 transition-colors bg-[#151B26]">
                    <td class="px-5 py-4 text-gray-300 font-medium whitespace-nowrap">{{ $pageSeos->firstItem() + $index }}</td>
                    <td class="px-5 py-4 text-indigo-300 font-medium font-mono">
                        {{ $seo->url_path }}
                    </td>
                    <td class="px-5 py-4">
                        @if($seo->schema_tag)
                            <span class="inline-flex items-center py-1 px-2.5 rounded-full text-[10px] font-bold bg-[#044c3c] text-emerald-400 border border-emerald-500/20">YES</span>
                        @else
                            <span class="inline-flex items-center py-1 px-2.5 rounded-full text-[10px] font-bold bg-gray-800 text-gray-500 border border-gray-700">NO</span>
                        @endif
                    </td>
                    <td class="px-5 py-4 text-sm text-gray-400 whitespace-nowrap">
                        {{ $seo->created_at->format('M d, Y h:i A') }}
                    </td>
                    <td class="px-5 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <button type="button" class="flex items-center justify-center w-8 h-8 rounded bg-[#1f2937] hover:bg-[#2d3748] text-sky-400 transition-colors border border-gray-700/50 shadow-sm" title="Edit" 
                                data-id="{{ $seo->id }}"
                                data-url="{{ $seo->url_path }}"
                                data-schema="{{ current(array_filter([$seo->schema_tag])) ?: '' }}"
                                data-raw="{{ current(array_filter([$seo->raw_tags])) ?: '' }}"
                                onclick="openFormModalFromData(this)">
                                <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>
                            <button type="button" class="flex items-center justify-center w-8 h-8 rounded bg-[#4c1d1a]/50 hover:bg-[#4c1d1a] text-rose-400 transition-colors border border-rose-900/30 shadow-sm" title="Delete" onclick="openDeleteModal('{{ $seo->id }}', '{{ htmlspecialchars($seo->url_path, ENT_QUOTES) }}')">
                                <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">No page SEO configurations found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6 flex justify-end">
        {{ $pageSeos->links('pagination::tailwind') }}
    </div>
</div>

<!-- Add/Edit Modal -->
<div id="formModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/80 backdrop-blur-sm transition-opacity" style="opacity: 0;">
    <div class="bg-gray-800 border border-gray-700 rounded-2xl shadow-2xl max-w-2xl w-full overflow-hidden transform scale-95 transition-all duration-200" id="formModalPanel">
        <div class="p-6 border-b border-gray-700/50 flex justify-between items-center bg-gray-900/50">
            <h3 class="text-xl font-bold text-gray-100" id="formModalTitle">Add New SEO Path</h3>
            <button onclick="closeFormModal()" class="text-gray-400 hover:text-white"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
        </div>
        
        <form id="seoForm" method="POST" action="{{ route('admin.page_seo.store') }}">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            
            <div class="p-6 space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-300 mb-2">URL Path <span class="text-rose-500">*</span></label>
                    <input type="text" name="url_path" id="seoUrlPath" placeholder="e.g. /about-us" required class="w-full bg-gray-900/50 border border-gray-700 text-white px-4 py-2.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 font-mono">
                    <p class="text-xs text-gray-500 mt-1">Must exactly match the front-end path including the leading slash.</p>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-300 mb-2">Schema Tag (JSON-LD)</label>
                    <textarea name="schema_tag" id="seoSchemaTag" rows="5" class="w-full bg-gray-900/50 border border-gray-700 text-white px-4 py-2.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 font-mono text-sm" placeholder='<script type="application/ld+json">...</script>'></textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-300 mb-2">Raw Tags</label>
                    <textarea name="raw_tags" id="seoRawTags" rows="4" class="w-full bg-gray-900/50 border border-gray-700 text-white px-4 py-2.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 font-mono text-sm" placeholder='<meta name="..." content="..." />'></textarea>
                </div>
            </div>
            
            <div class="p-6 bg-gray-900/50 border-t border-gray-700/50 flex justify-end gap-3">
                <button type="button" onclick="closeFormModal()" class="px-6 py-2.5 rounded-xl text-sm font-medium text-gray-400 hover:text-white transition-all">Cancel</button>
                <button type="submit" class="px-8 py-2.5 rounded-xl text-sm font-bold text-white bg-blue-600 hover:bg-blue-500 shadow-lg shadow-blue-500/20 transition-all">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/80 backdrop-blur-sm transition-opacity" style="opacity: 0;">
    <div class="bg-gray-800 border border-gray-700 rounded-2xl shadow-2xl max-w-sm w-full overflow-hidden transform scale-95 transition-all duration-200" id="deleteModalPanel">
        <div class="p-6">
            <div class="flex items-center justify-center w-12 h-12 mx-auto bg-rose-500/10 rounded-full mb-4 shadow-inner">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            
            <h3 class="text-lg font-medium text-gray-100 text-center mb-2">Delete Path Rules</h3>
            <p class="text-sm text-gray-400 text-center" id="deleteModalMessage">Are you sure you want to remove SEO rules for <span id="deleteModalPath" class="text-gray-300 font-semibold font-mono break-all"></span>?</p>
        </div>
        
        <form id="deleteModalForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <div class="flex border-t border-gray-700 bg-gray-800/50">
                <button 
                    type="button"
                    onclick="closeDeleteModal()"
                    class="flex-1 px-4 py-3.5 text-sm font-medium text-gray-400 hover:text-gray-200 hover:bg-gray-700/50 transition-colors border-r border-gray-700 outline-none"
                >
                    Cancel
                </button>
                <button 
                    type="submit"
                    class="flex-1 px-4 py-3.5 text-sm font-medium text-rose-500 hover:bg-rose-500/10 hover:text-rose-400 transition-colors outline-none"
                >
                    Delete
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openFormModalFromData(btn) {
        openFormModal(
            btn.getAttribute('data-id'), 
            btn.getAttribute('data-url'), 
            btn.getAttribute('data-schema'), 
            btn.getAttribute('data-raw')
        );
    }

    function openFormModal(id = null, urlPath = '', schemaTag = '', rawTags = '') {
        const modal = document.getElementById('formModal');
        const panel = document.getElementById('formModalPanel');
        const form = document.getElementById('seoForm');
        
        document.getElementById('seoUrlPath').value = urlPath;
        document.getElementById('seoSchemaTag').value = schemaTag;
        document.getElementById('seoRawTags').value = rawTags;
        
        if (id) {
            document.getElementById('formModalTitle').innerText = 'Edit SEO Path';
            document.getElementById('formMethod').value = 'PUT';
            form.action = `{{ route('admin.page_seo.update', ':id') }}`.replace(':id', id);
        } else {
            document.getElementById('formModalTitle').innerText = 'Add New SEO Path';
            document.getElementById('formMethod').value = 'POST';
            form.action = `{{ route('admin.page_seo.store') }}`;
        }

        modal.classList.remove('hidden');
        void modal.offsetWidth;
        modal.style.opacity = '1';
        panel.classList.remove('scale-95');
        panel.classList.add('scale-100');
    }

    function closeFormModal() {
        const modal = document.getElementById('formModal');
        const panel = document.getElementById('formModalPanel');
        modal.style.opacity = '0';
        panel.classList.remove('scale-100');
        panel.classList.add('scale-95');
        setTimeout(() => modal.classList.add('hidden'), 200);
    }

    function openDeleteModal(id, path) {
        const modal = document.getElementById('deleteModal');
        const panel = document.getElementById('deleteModalPanel');
        
        document.getElementById('deleteModalPath').innerText = path;
        document.getElementById('deleteModalForm').action = `{{ route('admin.page_seo.destroy', ':id') }}`.replace(':id', id);
        
        modal.classList.remove('hidden');
        void modal.offsetWidth;
        modal.style.opacity = '1';
        panel.classList.remove('scale-95');
        panel.classList.add('scale-100');
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        const panel = document.getElementById('deleteModalPanel');
        
        modal.style.opacity = '0';
        panel.classList.remove('scale-100');
        panel.classList.add('scale-95');
        setTimeout(() => modal.classList.add('hidden'), 200);
    }
</script>
@endsection
