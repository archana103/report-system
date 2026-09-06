@extends('layouts.admin')

@section('header_title', 'Edit Blog Detail')

@section('content')
<div class="h-full bg-gray-800/40 rounded-3xl p-8 shadow-2xl border border-gray-700/50 backdrop-blur-sm relative overflow-y-auto w-full mx-auto">
    <div class="flex items-center justify-between mb-8 overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-600/10 to-transparent p-4 border-l-4 border-indigo-500">
        <div>
            <h2 class="text-2xl font-bold text-white tracking-tight">Edit Blog Detail</h2>
            <p class="text-gray-400 text-sm mt-1">Select a blog and add detailed rich content for it.</p>
        </div>
        <a href="{{ route('admin.blog_details.index') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-gray-800 hover:bg-gray-700 border border-gray-700 rounded-xl text-sm font-medium text-gray-300 hover:text-white shadow-sm transition-all focus:ring-2 focus:ring-gray-600 focus:outline-none">
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

    <form method="POST" action="{{ route('admin.blog_details.update', $detail->id) }}" class="space-y-8 pb-12">
        @csrf
        @method('PUT')

        <!-- Basic Info (NO Parent Blog dropdown in Edit Mode as per Vue Component) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8 bg-gray-900/40 rounded-3xl border border-gray-800 shadow-2xl backdrop-blur-sm">
            <!-- Hidden Parent Blog to satisfy validation if required -->
            <input type="hidden" name="blog_id" value="{{ $detail->blog_id }}">
            
            <div class="col-span-1 md:col-span-2 pb-2 border-b border-gray-800">
                <h3 class="text-lg font-bold text-gray-300">Basic Info</h3>
                <p class="text-xs text-gray-400 mt-1">Assigned Blog: {{ $detail->blog->title ?? 'N/A' }}</p>
            </div>

            <div class="col-span-1 md:col-span-2">
                <label class="block text-sm font-semibold text-gray-300 mb-3 ml-1">Blog detail Title <span class="text-rose-500">*</span></label>
                <input name="title" type="text" value="{{ old('title', $detail->title) }}" placeholder="Detailed subtitle or headline..." required class="w-full bg-gray-800 border border-gray-700/50 rounded-xl px-5 py-3 text-sm text-gray-200 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all shadow-inner" />
            </div>

            <div class="col-span-1 md:col-span-2">
                <label class="block text-sm font-semibold text-gray-300 mb-3 ml-1">Breadcrumb Title</label>
                <input name="breadcrumb_title" type="text" value="{{ old('breadcrumb_title', $detail->breadcrumb_title) }}" placeholder="Short title for breadcrumbs..." class="w-full bg-gray-800 border border-gray-700/50 rounded-xl px-5 py-3 text-sm text-gray-200 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all shadow-inner" />
            </div>
            
            <div class="col-span-1 md:col-span-2">
                <label class="block text-sm font-semibold text-gray-300 mb-3 ml-1">Blog detail Description</label>
                <div class="rounded-xl overflow-hidden shadow-sm border border-gray-700 bg-gray-800/50 transition-all">
                    <textarea name="description" id="blog-detail-editor" class="w-full bg-transparent p-4 text-white focus:outline-none min-h-[160px]">{{ old('description', $detail->description) }}</textarea>
                </div>
            </div>
        </div>

        <!-- SEO Optimization Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8 bg-gray-900/40 rounded-3xl border border-gray-800 shadow-2xl backdrop-blur-sm">
            <div class="col-span-1 md:col-span-2 pb-2 border-b border-gray-800">
                <h3 class="text-lg font-bold text-gray-300">SEO Optimization</h3>
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-400 mb-2 ml-1">Meta Title</label>
                <input name="meta_title" type="text" value="{{ old('meta_title', $detail->meta_title) }}" class="w-full bg-gray-800/60 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:ring-2 focus:ring-indigo-500/50" />
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-400 mb-2 ml-1">Meta Description</label>
                <textarea name="meta_description" rows="2" class="w-full bg-gray-800/60 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200 focus:ring-2 focus:ring-indigo-500/50">{{ old('meta_description', $detail->meta_description) }}</textarea>
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-400 mb-2 ml-1">Meta Keywords</label>
                <input name="meta_keywords" type="text" value="{{ old('meta_keywords', $detail->meta_keywords) }}" class="w-full bg-gray-800/60 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:ring-2 focus:ring-indigo-500/50" />
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-400 mb-2 ml-1">Canonical Tag</label>
                <input name="canonical_tag" type="text" value="{{ old('canonical_tag', $detail->canonical_tag) }}" class="w-full bg-gray-800/60 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:ring-2 focus:ring-indigo-500/50" />
            </div>
            
            <div class="col-span-1 md:col-span-2">
                <label class="block text-sm font-semibold text-gray-400 mb-2 ml-1">Meta Robots Tag</label>
                <textarea name="meta_robots" rows="1" class="w-full bg-gray-800/60 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200 focus:ring-2 focus:ring-indigo-500/50">{{ old('meta_robots', $detail->meta_robots) }}</textarea>
            </div>

            <!-- Hreflang Tags -->
            <div class="col-span-1 md:col-span-2 space-y-4" id="hreflang-container">
                <div class="flex items-center justify-between">
                    <label class="block text-sm font-semibold text-gray-400 ml-1">Blog Hreflang Tags</label>
                    <button type="button" onclick="addHreflang()" class="text-xs text-emerald-400 hover:text-emerald-300 flex items-center bg-emerald-500/10 px-3 py-1.5 rounded-lg border border-emerald-500/20 transition-all font-bold">+ Add Hreflang</button>
                </div>
                
                @php
                    $hreflangs = old('hreflang_tags', $detail->hreflang_tags ?? []);
                    if (!is_array($hreflangs)) $hreflangs = [];
                @endphp
                
                <div id="hreflang-list" class="space-y-2">
                    @foreach($hreflangs as $index => $href)
                        <div class="flex gap-2 hreflang-item">
                            <input name="hreflang_tags[]" type="text" value="{{ $href }}" placeholder="Enter hreflang tag..." class="flex-grow bg-gray-800/40 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200" />
                            <button type="button" onclick="this.parentElement.remove()" class="p-2 text-rose-400 hover:bg-rose-500/10 rounded-lg transition-all"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg></button>
                        </div>
                    @endforeach
                </div>
                <!-- Template for new hreflang -->
                <template id="hreflang-template">
                    <div class="flex gap-2 hreflang-item mt-2">
                        <input name="hreflang_tags[]" type="text" placeholder="Enter hreflang tag..." class="flex-grow bg-gray-800/40 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200" />
                        <button type="button" onclick="this.parentElement.remove()" class="p-2 text-rose-400 hover:bg-rose-500/10 rounded-lg transition-all"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg></button>
                    </div>
                </template>
            </div>
        </div>
        
        <!-- Social Meta (OG & Twitter) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8 bg-gray-900/40 rounded-3xl border border-gray-800 shadow-2xl backdrop-blur-sm">
            <div class="col-span-1 md:col-span-2 pb-2 border-b border-gray-800">
                <h3 class="text-lg font-bold text-gray-300">Open Graph Meta Tags</h3>
            </div>
            
            @php
                $ogLabels = ['One', 'Two', 'Three', 'Four', 'Five', 'Six'];
                $ogs = old('open_graph_tags', $detail->open_graph_tags ?? []);
            @endphp
            @for($i = 1; $i <= 6; $i++)
                <div>
                    <label class="block text-sm font-semibold text-gray-400 mb-2 ml-1">Open Graph Meta Tag {{ $ogLabels[$i-1] }}</label>
                    <textarea name="open_graph_tags[tag_{{ $i }}]" rows="2" class="w-full bg-gray-800/60 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200">{{ $ogs['tag_'.$i] ?? '' }}</textarea>
                </div>
            @endfor

            <div class="col-span-1 md:col-span-2 pb-2 border-b border-gray-800 mt-6">
                <h3 class="text-lg font-bold text-gray-300">Twitter Card Meta Tags</h3>
            </div>
            
            @php
                $twitters = old('twitter_card_tags', $detail->twitter_card_tags ?? []);
            @endphp
            @for($i = 1; $i <= 6; $i++)
                <div>
                    <label class="block text-sm font-semibold text-gray-400 mb-2 ml-1">Twitter Card Meta Tag {{ $ogLabels[$i-1] }}</label>
                    <textarea name="twitter_card_tags[tag_{{ $i }}]" rows="2" class="w-full bg-gray-800/60 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200">{{ $twitters['tag_'.$i] ?? '' }}</textarea>
                </div>
            @endfor
        </div>

        <!-- Schema Section -->
        <div class="grid grid-cols-1 gap-8 p-8 bg-gray-900/40 rounded-3xl border border-gray-800 shadow-2xl backdrop-blur-sm">
            <div class="pb-2 border-b border-gray-800">
                <h3 class="text-lg font-bold text-gray-300">Schema Tags</h3>
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-400 mb-2 ml-1">Schema Tag</label>
                <textarea name="schema_tag" rows="5" placeholder="{ ... }" class="w-full bg-gray-800/60 border border-gray-700 rounded-xl px-4 py-3 text-sm text-gray-200 font-mono">{{ old('schema_tag', $detail->schema_tag) }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-400 mb-2 ml-1">Schema Tag 2</label>
                <textarea name="schema_tag_2" rows="5" placeholder="{ ... }" class="w-full bg-gray-800/60 border border-gray-700 rounded-xl px-4 py-3 text-sm text-gray-200 font-mono">{{ old('schema_tag_2', $detail->schema_tag_2) }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-400 mb-2 ml-1">Schema Tag 3</label>
                <textarea name="schema_tag_3" rows="5" placeholder="{ ... }" class="w-full bg-gray-800/60 border border-gray-700 rounded-xl px-4 py-3 text-sm text-gray-200 font-mono">{{ old('schema_tag_3', $detail->schema_tag_3) }}</textarea>
            </div>
        </div>

        <!-- FAQs -->
        <div class="grid grid-cols-1 gap-6 p-8 bg-gray-900/40 rounded-3xl border border-gray-800 shadow-2xl backdrop-blur-sm" id="faqs-container">
            <div class="flex items-center justify-between pb-2 border-b border-gray-800">
                <h3 class="text-lg font-bold text-gray-300">FAQs</h3>
                <button type="button" onclick="addFaq()" class="text-xs text-blue-400 hover:text-blue-300 flex items-center bg-blue-500/10 px-3 py-1.5 rounded-lg border border-blue-500/20 transition-all font-bold">+ Add FAQ</button>
            </div>
            
            @php
                $faqs = old('faqs', $detail->faqs ?? []);
                if (!is_array($faqs)) $faqs = [];
            @endphp
            
            <div id="faqs-list" class="space-y-4">
                @foreach($faqs as $index => $faq)
                    <div class="p-4 bg-gray-800/20 rounded-2xl border border-gray-700/50 space-y-3 relative faq-item pt-8">
                        <span class="absolute top-2 left-4 text-xs font-bold text-gray-500 uppercase tracking-wider">FAQ #<span class="faq-number">{{ $index + 1 }}</span></span>
                        <div class="flex gap-4">
                            <div class="flex-grow space-y-3">
                                <input name="faqs[{{ $index }}][question]" value="{{ $faq['question'] ?? '' }}" type="text" placeholder="Question" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200" />
                                <textarea name="faqs[{{ $index }}][answer]" rows="2" placeholder="Answer" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200">{{ $faq['answer'] ?? '' }}</textarea>
                            </div>
                            <button type="button" onclick="removeFaq(this)" class="h-10 px-3 text-xs bg-rose-500/10 text-rose-500 border border-rose-500/20 rounded-lg hover:bg-rose-500 hover:text-white transition-all font-bold items-center justify-center flex">Delete</button>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Template for new FAQ -->
            <template id="faq-template">
                <div class="p-4 bg-gray-800/20 rounded-2xl border border-gray-700/50 space-y-3 relative faq-item pt-8 mt-4">
                    <span class="absolute top-2 left-4 text-xs font-bold text-gray-500 uppercase tracking-wider">FAQ #<span class="faq-number">INDEX_NUM</span></span>
                    <div class="flex gap-4">
                        <div class="flex-grow space-y-3">
                            <input name="faqs[INDEX][question]" type="text" placeholder="Question" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200" />
                            <textarea name="faqs[INDEX][answer]" rows="2" placeholder="Answer" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200"></textarea>
                        </div>
                        <button type="button" onclick="removeFaq(this)" class="h-10 px-3 text-xs bg-rose-500/10 text-rose-500 border border-rose-500/20 rounded-lg hover:bg-rose-500 hover:text-white transition-all font-bold items-center justify-center flex">Delete</button>
                    </div>
                </div>
            </template>
        </div>
        
        <script>
            function addHreflang() {
                const list = document.getElementById('hreflang-list');
                const tpl = document.getElementById('hreflang-template');
                list.appendChild(tpl.content.cloneNode(true));
            }
            
            let faqCount = {{ count($faqs) }};
            function addFaq() {
                const list = document.getElementById('faqs-list');
                const tpl = document.getElementById('faq-template').innerHTML;
                const index = faqCount++;
                const newHtml = tpl.replace(/INDEX_NUM/g, index + 1).replace(/INDEX/g, index);
                
                const wrapper = document.createElement('div');
                wrapper.innerHTML = newHtml;
                list.appendChild(wrapper.firstElementChild);
            }
            
            function removeFaq(btn) {
                btn.closest('.faq-item').remove();
            }
        </script>

        <!-- Actions -->
        <div class="flex items-center justify-end space-x-4 w-full pt-4">
            <a href="{{ route('admin.blog_details.index') }}" class="px-8 py-3 rounded-xl text-sm font-medium text-gray-400 hover:text-white transition-all">Cancel</a>
            <button type="submit" class="px-10 py-3 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-500 hover:to-blue-500 shadow-xl shadow-indigo-500/20 transition-all active:scale-95">
                Update Detail
            </button>
        </div>
    </form>
</div>

<!-- Load TinyMCE for Textarea -->
<script>
    if (typeof tinymce !== 'undefined') {
        tinymce.init({
            selector: 'textarea[name="description"]',
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
            height: 450
        });
    }
</script>
@endsection
