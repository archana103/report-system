@extends('layouts.admin')

@section('header_title', 'Edit Report Category')

@section('content')
<div class="h-full bg-gray-800/40 rounded-3xl p-8 shadow-2xl border border-gray-700/50 backdrop-blur-sm relative overflow-y-auto w-full mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-medium text-white tracking-tight">Edit Report Category</h2>
        <a href="{{ route('admin.categories.index') }}" class="text-gray-400 hover:text-white transition-colors">
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

    <form method="POST" action="{{ route('admin.categories.update', $category->id) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Row 1 -->
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5 ml-1">Report Category Name <span class="text-rose-500">*</span></label>
                <input name="name" type="text" value="{{ old('name', $category->name) }}" required class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500/50 focus:border-teal-500/50 transition-all" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5 ml-1">Slug URL</label>
                <input name="slug_url" type="text" value="{{ old('slug_url', $category->slug_url) }}" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500/50 focus:border-teal-500/50 transition-all" />
            </div>

            <!-- Row 2 -->
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5 ml-1">Status  <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <select name="status" required class="w-full bg-gray-800/80 border border-gray-700 rounded-xl pl-4 pr-10 py-2.5 text-sm text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500/50 focus:border-teal-500/50 transition-all appearance-none cursor-pointer">
                        <option value="">---</option>
                        <option value="Active" @if(old('status', $category->status) == 'Active') selected @endif>Active</option>
                        <option value="Inactive" @if(old('status', $category->status) == 'Inactive') selected @endif>Inactive</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                        <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                    </div>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5 ml-1">Main Heading</label>
                <input name="main_heading" type="text" value="{{ old('main_heading', $category->main_heading) }}" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500/50 focus:border-teal-500/50 transition-all" />
            </div>

            <!-- Row 3 -->
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5 ml-1">Category Image</label>
                @if($category->category_image)
                    <div class="mb-3">
                        <img src="{{ Str::startsWith($category->category_image, 'http') ? $category->category_image : env('AWS_URL') . '/' . $category->category_image }}" alt="Category Image" class="h-24 w-auto rounded-lg border border-gray-700 object-cover shadow-sm">
                    </div>
                @endif
                <input name="category_image" type="file" accept="image/*" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500/50 transition-all file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:bg-gray-700 file:text-gray-200 hover:file:bg-gray-600" />
                <p class="text-[11px] text-gray-500 mt-1.5 ml-1">Leave empty to keep existing image</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5 ml-1">Category Icon (20x20px)</label>
                @if($category->category_icon)
                    <div class="mb-3">
                        <img src="{{ Str::startsWith($category->category_icon, 'http') ? $category->category_icon : env('AWS_URL') . '/' . $category->category_icon }}" alt="Category Icon" class="h-10 w-10 rounded border border-gray-700 object-cover bg-gray-900 shadow-sm">
                    </div>
                @endif
                <input name="category_icon" type="file" accept="image/*" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-200 focus:outline-none focus:ring-2 focus:ring-teal-500/50 transition-all file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:bg-gray-700 file:text-gray-200 hover:file:bg-gray-600" />
                <p class="text-[11px] text-gray-500 mt-1.5 ml-1">Leave empty to keep existing icon</p>
            </div>
        </div>

        <!-- Row 4: CKEditor -->
        <div>
            <label class="block text-sm font-medium text-gray-400 mb-1.5 ml-1">Main Subheading</label>
            <div class="rounded-xl overflow-hidden shadow-sm border border-gray-700 bg-gray-800/50 transition-all">
                <textarea name="main_subheading" class="w-full bg-transparent p-4 text-white focus:outline-none min-h-[160px]">{{ old('main_subheading', $category->main_subheading) }}</textarea>
            </div>
        </div>

        <div class="pt-4 border-t border-gray-700/50">
            <div class="flex items-center">
                <button type="submit" class="bg-gradient-to-r from-teal-500 to-emerald-600 hover:from-teal-400 hover:to-emerald-500 text-white font-medium py-2.5 px-8 rounded-xl shadow-lg shadow-teal-500/20 transition-all active:scale-95 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    Update Category
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Load TinyMCE for Textarea -->
<script>
    if (typeof tinymce !== 'undefined') {
        tinymce.init({
            selector: 'textarea[name="main_subheading"]',
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
            height: 350
        });
    }
</script>
@endsection
