@extends('layouts.admin')

@section('header_title', 'Edit Report Details')

@section('content')
<div class="h-full bg-gray-800/40 rounded-3xl p-8 shadow-2xl border border-gray-700/50 backdrop-blur-sm relative overflow-y-auto w-full mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-medium text-white tracking-tight">Edit Report Details</h2>
        <a href="{{ route('admin.report_details.index') }}" class="text-gray-400 hover:text-white transition-colors">
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

    <form method="POST" action="{{ route('admin.report_details.update', $detail->id) }}" enctype="multipart/form-data" class="space-y-8" id="reportDetailsForm">
        @csrf
        @method('PUT')
        
        <!-- General Information -->
        <div class="space-y-6">
            <h3 class="text-lg font-medium text-white border-b border-gray-700/50 pb-2">General Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">
                        Select Report <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="report_list_id" required class="w-full bg-gray-800/80 border border-gray-700 rounded-xl pl-4 pr-10 py-2.5 text-sm text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                            <option value="" disabled>---</option>
                            @foreach($reportLists as $list)
                                <option value="{{ $list->id }}" {{ old('report_list_id', $detail->report_list_id) == $list->id ? 'selected' : '' }}>
                                    {{ $list->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                            <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Slug URL</label>
                    <input type="text" name="slug_url" value="{{ old('slug_url', $detail->slug_url) }}" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50" />
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Breadcrumb Title</label>
                    <input type="text" name="breadcrumb_title" value="{{ old('breadcrumb_title', $detail->breadcrumb_title) }}" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50" />
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Page Main Title</label>
                    <input type="text" name="page_main_title" value="{{ old('page_main_title', $detail->page_main_title) }}" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50" />
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Add Report Id:</label>
                    <input type="text" name="report_sku" value="{{ old('report_sku', $detail->report_sku) }}" placeholder="e.g. SE2148" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Upload New Image</label>
                    @if($detail->image)
                        <div class="mb-3">
                            @php
                                $imgUrl = $detail->image;
                                if (!Str::startsWith($imgUrl, ['http://', 'https://'])) {
                                    $imgUrl = rtrim(env('AWS_URL'), '/') . '/' . ltrim($imgUrl, '/');
                                }
                            @endphp
                            <img src="{{ $imgUrl }}" class="h-20 rounded-md border border-gray-700 object-cover" alt="Current Image">
                        </div>
                    @endif
                    <div class="flex items-center justify-center w-full">
                        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-xl cursor-pointer bg-gray-900/50 border-gray-700 hover:bg-gray-800/50 hover:border-gray-500 transition-colors">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-3 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                </svg>
                                <p class="mb-2 text-sm text-gray-400"><span class="font-semibold text-blue-400">Click to upload</span> or drag and drop</p>
                                <p class="text-xs text-gray-500">JPG, JPEG, PNG, GIF (Max size: 2MB)</p>
                            </div>
                            <input type="file" name="image" class="hidden" accept="image/*" onchange="document.getElementById('file-chosen-status').innerText = this.files[0] ? this.files[0].name : 'No file chosen';"/>
                        </label>
                    </div>
                    <p id="file-chosen-status" class="text-xs text-emerald-400 mt-2 ml-1"></p>
                </div>
            </div>
        </div>

        <!-- Report Content -->
        <div class="space-y-6">
            <h3 class="text-lg font-medium text-white border-b border-gray-700/50 pb-2">Report Content</h3>
            
            <div>
                <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Section 1. About This Report</label>
                <textarea id="editor-description" name="description" class="hidden">{{ old('description', $detail->description) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Manage Table of Contents</label>
                <textarea id="editor-toc" name="table_of_contents" class="hidden">{{ old('table_of_contents', $detail->table_of_contents) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                   <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Meta Title</label>
                   <input type="text" name="meta_title" value="{{ old('meta_title', $detail->meta_title) }}" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50" />
                </div>
                <div>
                   <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Meta Description</label>
                   <textarea name="meta_description" rows="2" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50">{{ old('meta_description', $detail->meta_description) }}</textarea>
                </div>
                <div>
                   <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Meta Keywords</label>
                   <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $detail->meta_keywords) }}" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                   <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Canonical Tag</label>
                   <input type="text" name="canonical_tag" value="{{ old('canonical_tag', $detail->canonical_tag) }}" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50" />
                </div>
                <div>
                   <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Meta Robots Tag</label>
                   <input type="text" name="meta_robots" value="{{ old('meta_robots', $detail->meta_robots) }}" placeholder="index, follow" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50" />
                </div>
            </div>
        </div>

        <!-- Hreflang Tags -->
        <div class="space-y-4">
            <div class="flex justify-between items-center border-b border-gray-700/50 pb-2">
                <h3 class="text-lg font-medium text-white">Hreflang Tags</h3>
                <button type="button" onclick="addHreflang()" class="bg-emerald-600 hover:bg-emerald-500 text-white px-3 py-1 text-sm rounded-lg flex items-center transition-colors">
                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg> Add
                </button>
            </div>
            <div id="hreflang_container" class="space-y-3">
                @php
                    $hreflangs = old('hreflang_tags', $detail->hreflang_tags ?? []);
                    if (is_string($hreflangs)) $hreflangs = json_decode($hreflangs, true) ?: [];
                @endphp
                @foreach($hreflangs as $index => $val)
                    <div class="flex items-center space-x-3 tag-group">
                        <input type="text" name="hreflang_tags[]" value="{{ $val }}" placeholder="Enter hreflang tag" class="flex-grow bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50" />
                        <button type="button" onclick="this.parentElement.remove()" class="bg-red-500/20 text-red-400 hover:bg-red-500/30 p-2 rounded-lg transition-colors" title="Remove">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        </button>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Open Graph & Twitter Cards -->
        <div class="space-y-6">
            <h3 class="text-lg font-medium text-white border-b border-gray-700/50 pb-2">Open Graph Meta Tags</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @php
                    $ogs = old('open_graph_tags', $detail->open_graph_tags ?? []);
                    if (is_string($ogs)) $ogs = json_decode($ogs, true) ?: [];
                    $labels = ['One','Two','Three','Four','Five','Six'];
                @endphp
                @for ($i = 0; $i < 6; $i++)
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 mb-1 ml-1">Open Graph Meta Tag {{ $labels[$i] }}</label>
                        <input type="text" name="open_graph_tags[]" value="{{ $ogs[$i] ?? '' }}" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200" />
                    </div>
                @endfor
            </div>

            <h3 class="text-lg font-medium text-white border-b border-gray-700/50 pb-2 mt-6">Twitter Card Meta Tags</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @php
                    $tws = old('twitter_card_tags', $detail->twitter_card_tags ?? []);
                    if (is_string($tws)) $tws = json_decode($tws, true) ?: [];
                @endphp
                @for ($i = 0; $i < 6; $i++)
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 mb-1 ml-1">Twitter Card Meta Tag {{ $labels[$i] }}</label>
                        <input type="text" name="twitter_card_tags[]" value="{{ $tws[$i] ?? '' }}" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200" />
                    </div>
                @endfor
            </div>
        </div>

        <!-- Schema Tags -->
        <div class="space-y-6 border-b border-gray-700/50 pb-6">
            <div>
               <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Schema tag</label>
               <textarea name="schema_tag" rows="3" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-3 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50">{{ old('schema_tag', $detail->schema_tag) }}</textarea>
            </div>
            <div>
               <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Schema tag 2</label>
               <textarea name="schema_tag_2" rows="3" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-3 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50">{{ old('schema_tag_2', $detail->schema_tag_2) }}</textarea>
            </div>

            <h3 class="text-lg font-medium text-white pt-4">Custom Schema Tags</h3>
            <div id="schema_container">
                @php
                    $schemas = old('custom_schema_tags', $detail->custom_schema_tags ?? []);
                    if (is_string($schemas)) $schemas = json_decode($schemas, true) ?: [];
                @endphp
                @foreach($schemas as $index => $val)
                    <div class="bg-gray-800/40 p-4 rounded-xl border border-gray-700 mb-4 tag-group relative">
                        <textarea name="custom_schema_tags[]" rows="3" placeholder="Enter Schema Tag" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-sm text-gray-200 mb-3">{{ collect($val)->first() ?: (is_string($val) ? $val : '') }}</textarea>
                        <button type="button" onclick="this.parentElement.remove()" class="bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white px-4 py-1.5 text-sm rounded-lg transition-colors inline-block">Remove</button>
                    </div>
                @endforeach
            </div>
            <button type="button" onclick="addSchema()" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 text-sm rounded-lg transition-colors">Add Schema Tag</button>
        </div>

        <!-- FAQs -->
        <div class="space-y-4 border-b border-gray-700/50 pb-6">
            <h3 class="text-lg font-medium text-white">Frequently Asked Questions</h3>
            <div id="faq_container">
                @php
                    $faqs = old('faqs', $detail->faqs ?? []);
                    if (is_string($faqs)) $faqs = json_decode($faqs, true) ?: [];
                    // Flatten JSON object wrapping if passed
                    if(isset($faqs['faqs'])) $faqs = $faqs['faqs'];
                @endphp
                @foreach($faqs as $index => $faq)
                    @php 
                        $q = is_array($faq) ? ($faq['question'] ?? '') : '';
                        $a = is_array($faq) ? ($faq['answer'] ?? '') : '';
                    @endphp
                    <div class="bg-gray-800/40 p-4 rounded-xl border border-gray-700 mb-4 tag-group relative grid grid-cols-1 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-400 mb-1 ml-1">Question</label>
                            <input type="text" name="faqs[{{$index}}][question]" value="{{ $q }}" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-400 mb-1 ml-1">Answer</label>
                            <textarea name="faqs[{{$index}}][answer]" rows="2" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200">{{ $a }}</textarea>
                        </div>
                        <button type="button" onclick="this.parentElement.remove()" class="bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white px-4 py-1.5 text-sm rounded-lg transition-colors justify-self-start">Remove FAQ</button>
                    </div>
                @endforeach
            </div>
            <button type="button" onclick="addFaq()" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 text-sm rounded-lg transition-colors">Add FAQ</button>
        </div>

        <!-- License & Downloads -->
        <div class="space-y-6 pt-2">
            <h3 class="text-lg font-medium text-white pb-2">License & Downloads</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                   <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Report Details Title</label>
                   <textarea name="title" rows="2" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50">{{ old('title', $detail->title) }}</textarea>
                </div>
                
                <div>
                   <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Report Details Description</label>
                   <textarea name="detail_description" rows="2" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50">{{ old('detail_description', $detail->detail_description) }}</textarea>
                </div>

                <div>
                   <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Report Category List Download</label>
                   <textarea name="category_list_download" rows="2" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50">{{ old('category_list_download', $detail->category_list_download) }}</textarea>
                </div>
                
                <div>
                   <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Report Details Download Text</label>
                   <textarea name="download_text" rows="2" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50">{{ old('download_text', $detail->download_text) }}</textarea>
                </div>
                
                <div>
                   <label class="block text-sm font-semibold text-gray-300 mb-1.5 ml-1">Status</label>
                   <select name="status" required class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-3 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50">
                        <option value="Active" {{ old('status', $detail->status) == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ old('status', $detail->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                   </select>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="pt-6 border-t border-gray-700/50">
            <div class="flex items-center">
                <button type="submit" class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-400 hover:to-indigo-500 text-white font-medium py-3 px-8 rounded-xl shadow-lg shadow-blue-500/20 transition-all active:scale-95 flex items-center justify-center">
                    <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    Update Details
                </button>
            </div>
        </div>
    </form>
</div>

<!-- TinyMCE Initialization -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const initMCE = (selector) => {
            tinymce.init({
                selector: selector,
                menubar: 'file edit view insert format tools table help',
                plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                    'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                    'insertdatetime', 'media', 'table', 'help', 'wordcount'
                ],
                toolbar: 'undo redo | blocks fontfamily fontsize | ' +
                    'bold italic underline strikethrough | forecolor backcolor | ' +
                    'link image media table | alignleft aligncenter alignright alignjustify | ' +
                    'bullist numlist outdent indent | removeformat | code fullscreen help',
                skin: 'oxide-dark',
                content_css: 'dark',
                height: 400,
                promotion: false,
                branding: false,
                images_upload_url: "{{ route('admin.report_details.upload_image') }}",
                images_upload_credentials: true,
                relative_urls: false,
                remove_script_host: false,
                convert_urls: true
            });
        };

        if(document.getElementById('editor-description')) initMCE('#editor-description');
        if(document.getElementById('editor-toc')) initMCE('#editor-toc');
    });

    // Dynamic field scripts
    function addHreflang() {
        const container = document.getElementById('hreflang_container');
        const div = document.createElement('div');
        div.className = 'flex items-center space-x-3 tag-group';
        div.innerHTML = `
            <input type="text" name="hreflang_tags[]" placeholder="Enter hreflang tag" class="flex-grow bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200 focus:ring-2 focus:ring-blue-500/50" />
            <button type="button" onclick="this.parentElement.remove()" class="bg-red-500/20 text-red-400 hover:bg-red-500/30 p-2 rounded-lg transition-colors" title="Remove">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
            </button>
        `;
        container.appendChild(div);
    }

    function addSchema() {
        const container = document.getElementById('schema_container');
        const div = document.createElement('div');
        div.className = 'bg-gray-800/40 p-4 rounded-xl border border-gray-700 mb-4 tag-group relative';
        div.innerHTML = `
            <textarea name="custom_schema_tags[]" rows="3" placeholder="Enter Schema Tag" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-sm text-gray-200 mb-3"></textarea>
            <button type="button" onclick="this.parentElement.remove()" class="bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white px-4 py-1.5 text-sm rounded-lg transition-colors inline-block">Remove</button>
        `;
        container.appendChild(div);
    }

    let faqIndexCounter = Date.now();
    function addFaq() {
        const container = document.getElementById('faq_container');
        const count = container.querySelectorAll('.tag-group').length + faqIndexCounter++;
        const div = document.createElement('div');
        div.className = 'bg-gray-800/40 p-4 rounded-xl border border-gray-700 mb-4 tag-group relative grid grid-cols-1 gap-4';
        div.innerHTML = `
            <div>
                <label class="block text-xs font-semibold text-gray-400 mb-1 ml-1">Question</label>
                <input type="text" name="faqs[${count}][question]" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200" />
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-400 mb-1 ml-1">Answer</label>
                <textarea name="faqs[${count}][answer]" rows="2" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200"></textarea>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white px-4 py-1.5 text-sm rounded-lg transition-colors justify-self-start">Remove FAQ</button>
        `;
        container.appendChild(div);
    }
</script>
@endsection
