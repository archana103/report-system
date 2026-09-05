@extends('layouts.admin')

@section('header_title', 'Edit Press Release Detail')

@section('content')
<div class="h-full bg-gray-800/40 rounded-3xl p-8 shadow-2xl border border-gray-700/50 backdrop-blur-sm relative overflow-y-auto w-full mx-auto">
    <div class="flex items-center justify-between mb-8 overflow-hidden rounded-2xl bg-gradient-to-r from-teal-600/10 to-transparent p-4 border-l-4 border-teal-500">
        <div>
            <h2 class="text-2xl font-bold text-white tracking-tight">Edit Press Release Detail</h2>
            <p class="text-gray-400 text-sm mt-1">Edit: {{ $detail->pressRelease->title ?? 'N/A' }}</p>
        </div>
        <a href="{{ route('admin.press_release_details.index') }}" class="text-gray-400 hover:text-white transition-colors">
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

    <form method="POST" action="{{ route('admin.press_release_details.update', $detail->id) }}" class="space-y-8 pb-12">
        @csrf
        @method('PUT')

        <!-- Main Content & Basic SEO -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8 bg-gray-900/40 rounded-3xl border border-gray-800 shadow-2xl backdrop-blur-sm">
            <input type="hidden" name="press_release_id" value="{{ $detail->press_release_id }}">
            
            <div class="col-span-1 md:col-span-2 pb-2 border-b border-gray-800">
                <h3 class="text-lg font-bold text-gray-300">Main Content & Basic SEO</h3>
            </div>

            <div class="col-span-1">
                <label class="block text-sm font-semibold text-gray-300 mb-3 ml-1">Select Press Release <span class="text-rose-500">*</span></label>
                <input type="text" disabled value="{{ $detail->pressRelease->title ?? 'N/A' }}" class="w-full bg-gray-800/60 border border-gray-700/50 rounded-xl px-4 py-2.5 text-sm text-gray-400 cursor-not-allowed shadow-inner" />
            </div>

            <div class="col-span-1">
                <label class="block text-sm font-semibold text-gray-300 mb-3 ml-1">Slug URL</label>
                <input name="slug_url" type="text" value="{{ old('slug_url', $detail->slug_url) }}" placeholder="e.g. global-ammonia-prices-ease" class="w-full bg-gray-800 border border-gray-700/50 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:ring-2 focus:ring-teal-500/50 shadow-inner" />
            </div>

            <div class="col-span-1">
                <label class="block text-sm font-semibold text-gray-300 mb-3 ml-1">Page Main Title</label>
                <input name="page_main_title" type="text" value="{{ old('page_main_title', $detail->page_main_title) }}" placeholder="Main Title..." class="w-full bg-gray-800 border border-gray-700/50 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:ring-2 focus:ring-teal-500/50 shadow-inner" />
            </div>

            <div class="col-span-1">
                <label class="block text-sm font-semibold text-gray-300 mb-3 ml-1">Breadcrumb Title</label>
                <input name="breadcrumb_title" type="text" value="{{ old('breadcrumb_title', $detail->breadcrumb_title) }}" placeholder="Breadcrumb Title..." class="w-full bg-gray-800 border border-gray-700/50 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:ring-2 focus:ring-teal-500/50 shadow-inner" />
            </div>
            
            <div class="col-span-1 md:col-span-2">
                <label class="block text-sm font-semibold text-gray-300 mb-3 ml-1">Press Release Content</label>
                <div class="rounded-xl overflow-hidden shadow-sm border border-gray-700 bg-gray-800/50 transition-all">
                    <textarea name="content" id="pr-detail-editor" class="w-full bg-transparent p-4 text-white focus:outline-none min-h-[160px]">{{ old('content', $detail->content) }}</textarea>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8 bg-gray-900/40 rounded-3xl border border-gray-800 shadow-2xl backdrop-blur-sm">
            <div>
                <label class="block text-sm font-semibold text-gray-400 mb-2 ml-1">Press Release Meta Title</label>
                <input name="meta_title" type="text" value="{{ old('meta_title', $detail->meta_title) }}" class="w-full bg-gray-800/60 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:ring-2 focus:ring-teal-500/50" />
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-400 mb-2 ml-1">Press Release Meta Description</label>
                <textarea name="meta_description" rows="2" class="w-full bg-gray-800/60 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200 focus:ring-2 focus:ring-teal-500/50">{{ old('meta_description', $detail->meta_description) }}</textarea>
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-400 mb-2 ml-1">Press Release Meta Keywords</label>
                <input name="meta_keywords" type="text" value="{{ old('meta_keywords', $detail->meta_keywords) }}" class="w-full bg-gray-800/60 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:ring-2 focus:ring-teal-500/50" />
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-400 mb-2 ml-1">Canonical Tag</label>
                <input name="canonical_tag" type="text" value="{{ old('canonical_tag', $detail->canonical_tag) }}" class="w-full bg-gray-800/60 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:ring-2 focus:ring-teal-500/50" />
            </div>
            
            <div class="col-span-1 md:col-span-2">
                <label class="block text-sm font-semibold text-gray-400 mb-2 ml-1">Meta Robots Tag</label>
                <input name="meta_robots" type="text" value="{{ old('meta_robots', $detail->meta_robots) }}" placeholder="index, follow" class="w-full bg-gray-800/60 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200 focus:ring-2 focus:ring-teal-500/50" />
            </div>
        </div>

        <div class="p-8 bg-gray-900/40 rounded-3xl border border-gray-800 shadow-2xl backdrop-blur-sm" id="hreflang-container">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-300">Press Release Hreflang Tags</h3>
                <button type="button" onclick="addHreflang()" class="text-xs text-teal-400 hover:text-teal-300 flex items-center bg-teal-500/10 px-4 py-2 rounded-lg border border-teal-500/20 transition-all font-bold">+ Add Hreflang Tag</button>
            </div>
            
            @php
                $hreflangs = old('hreflang_tags', $detail->hreflang_tags ?? []);
                if (!is_array($hreflangs)) $hreflangs = [];
            @endphp
            
            @if(count($hreflangs) === 0)
                <p class="text-xs text-gray-600 italic" id="no-hreflang-msg">No hreflang tags added.</p>
            @endif

            <div id="hreflang-list" class="space-y-3">
                @foreach($hreflangs as $index => $href)
                    <div class="flex gap-2 hreflang-item">
                        <input name="hreflang_tags[]" type="text" value="{{ $href }}" placeholder="Enter hreflang tag..." class="flex-grow bg-gray-800/40 border border-gray-700/50 rounded-xl px-4 py-2.5 text-sm text-gray-200" />
                        <button type="button" onclick="removeHreflang(this)" class="p-2.5 text-rose-400 hover:bg-rose-500/10 rounded-xl transition-all border border-transparent hover:border-rose-500/20"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg></button>
                    </div>
                @endforeach
            </div>
            
            <!-- Template for new hreflang -->
            <template id="hreflang-template">
                <div class="flex gap-2 hreflang-item mt-3">
                    <input name="hreflang_tags[]" type="text" placeholder="Enter hreflang tag..." class="flex-grow bg-gray-800/40 border border-gray-700/50 rounded-xl px-4 py-2.5 text-sm text-gray-200" />
                    <button type="button" onclick="removeHreflang(this)" class="p-2.5 text-rose-400 hover:bg-rose-500/10 rounded-xl transition-all border border-transparent hover:border-rose-500/20"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg></button>
                </div>
            </template>
        </div>
        
        <!-- Social Meta (OG & Twitter) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8 bg-gray-900/40 rounded-3xl border border-gray-800 shadow-2xl backdrop-blur-sm">
            <div class="col-span-1 md:col-span-2 pb-2 border-b border-gray-800">
                <h3 class="text-lg font-bold text-gray-300">Open Graph Meta Tags</h3>
            </div>
            
            @php
                $ogLabels = ['One', 'Two', 'Three', 'Four', 'Five', 'Six'];
                $ogs = old('open_graph_tags', $detail->open_graph_tags ?? []);
                if(!is_array($ogs)) $ogs = [];
            @endphp
            @for($i = 0; $i < 6; $i++)
                <div>
                    <label class="block text-sm font-semibold text-gray-400 mb-2 ml-1">Open Graph Meta Tag {{ $ogLabels[$i] }}</label>
                    <textarea name="open_graph_tags[{{ $i }}]" rows="2" class="w-full bg-gray-800/60 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200 focus:border-teal-500/50">{{ $ogs[$i] ?? '' }}</textarea>
                </div>
            @endfor

            <div class="col-span-1 md:col-span-2 pb-2 border-b border-gray-800 mt-6">
                <h3 class="text-lg font-bold text-gray-300">Twitter Card Meta Tags</h3>
            </div>
            
            @php
                $twitters = old('twitter_card_tags', $detail->twitter_card_tags ?? []);
                if(!is_array($twitters)) $twitters = [];
            @endphp
            @for($i = 0; $i < 6; $i++)
                <div>
                    <label class="block text-sm font-semibold text-gray-400 mb-2 ml-1">Twitter Card Meta Tag {{ $ogLabels[$i] }}</label>
                    <textarea name="twitter_card_tags[{{ $i }}]" rows="2" class="w-full bg-gray-800/60 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200 focus:border-teal-500/50">{{ $twitters[$i] ?? '' }}</textarea>
                </div>
            @endfor
        </div>

        <!-- Schema Section -->
        <div class="grid grid-cols-1 gap-8 p-8 bg-gray-900/40 rounded-3xl border border-gray-800 shadow-2xl backdrop-blur-sm">
            <div>
                <label class="block text-sm font-semibold text-gray-400 mb-2 ml-1">Schema tag</label>
                <textarea name="schema_tag" rows="5" class="w-full bg-gray-800/60 border border-gray-700 rounded-xl px-4 py-3 text-sm text-gray-200 font-mono">{{ old('schema_tag', $detail->schema_tag) }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-400 mb-2 ml-1">Schema tag 2</label>
                <textarea name="schema_tag_2" rows="5" class="w-full bg-gray-800/60 border border-gray-700 rounded-xl px-4 py-3 text-sm text-gray-200 font-mono">{{ old('schema_tag_2', $detail->schema_tag_2) }}</textarea>
            </div>
        </div>

        <script>
            function addHreflang() {
                const msg = document.getElementById('no-hreflang-msg');
                if (msg) msg.style.display = 'none';

                const list = document.getElementById('hreflang-list');
                const tpl = document.getElementById('hreflang-template');
                list.appendChild(tpl.content.cloneNode(true));
            }

            function removeHreflang(btn) {
                btn.parentElement.remove();
                const list = document.getElementById('hreflang-list');
                const msg = document.getElementById('no-hreflang-msg');
                if (list.children.length === 0 && msg) {
                    msg.style.display = 'block';
                }
            }
        </script>

        <!-- Actions -->
        <div class="flex items-center justify-end space-x-4 w-full pt-4">
            <a href="{{ route('admin.press_release_details.index') }}" class="px-8 py-3 rounded-xl text-sm font-medium text-gray-400 hover:text-white transition-all">Cancel</a>
            <button type="submit" class="px-10 py-3 rounded-xl text-sm font-bold text-white bg-[#0f766e] hover:bg-[#115e59] shadow-xl shadow-teal-900/20 transition-all active:scale-95">
                Update Detail
            </button>
        </div>
    </form>
</div>

<!-- Load TinyMCE for Textarea -->
<script>
    if (typeof tinymce !== 'undefined') {
        tinymce.init({
            selector: 'textarea[name="content"]',
            menubar: 'file edit view insert format tools table help',
            promotion: false,
            skin: 'oxide-dark',
            content_css: 'dark',
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'code', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks fontfamily fontsize | ' +
                'bold italic underline strikethrough | forecolor backcolor | ' +
                'link image media table | alignleft aligncenter alignright alignjustify | ' +
                'bullist numlist outdent indent | removeformat | code fullscreen help',
            height: 500
        });
    }
</script>
@endsection
