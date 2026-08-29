@extends('layouts.admin')

@section('header_title', 'Report Methodology')

@section('content')
<div class="h-full bg-gray-800/40 rounded-3xl p-6 lg:p-8 shadow-2xl border border-gray-700/50 backdrop-blur-sm relative flex flex-col min-h-0 w-full overflow-hidden">
    <div class="flex justify-between items-center mb-6 shrink-0">
        <h2 class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-indigo-500">Report Methodology</h2>
    </div>

    <!-- Form Section -->
    <div class="flex-1 overflow-y-auto custom-scrollbar bg-gray-900/50 border border-gray-700/50 rounded-2xl p-6 shadow-inner">
        <form action="{{ route('admin.methodology.store') }}" method="POST">
            @csrf
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-300 mb-3 ml-1">Global Methodology Content</label>
                <div class="rounded-xl overflow-hidden border border-gray-700 focus-within:border-indigo-500/50 focus-within:ring-1 focus-within:ring-indigo-500/50 transition-all">
                    <textarea name="content" id="methodologyEditor" class="w-full hidden">{{ old('content', $methodology->content ?? '') }}</textarea>
                </div>
                @error('content')
                    <p class="text-rose-400 text-sm mt-2 ml-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 border-t border-gray-700/50 flex justify-end">
                <button type="submit" class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-medium py-3 px-8 rounded-xl shadow-lg shadow-indigo-500/20 transition-all active:scale-95 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                    Save Component
                </button>
            </div>
        </form>
    </div>
</div>

<!-- TinyMCE Initialization -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const initMCE = (selector) => {
            if (typeof tinymce !== 'undefined') {
                tinymce.init({
                    selector: selector,
                    skin: 'oxide-dark',
                    content_css: 'dark',
                    height: 500,
                    menubar: 'file edit view insert format tools table help',
                    plugins: [
                        'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                        'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                        'insertdatetime', 'media', 'table', 'help', 'wordcount', 'codesample'
                    ],
                    toolbar: 'undo redo | blocks | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | image link codesample | help',
                    content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; font-size: 14px; background-color: #1e293b; color: #ffffff; }',
                    branding: false,
                    promotion: false,
                    images_upload_credentials: true,
                    images_upload_handler: function (blobInfo, progress) {
                        return new Promise((resolve, reject) => {
                            const xhr = new XMLHttpRequest();
                            xhr.withCredentials = true;
                            xhr.open('POST', '{{ route('admin.report_details.upload_image') }}');
                            
                            xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

                            xhr.upload.onprogress = (e) => {
                                progress(e.loaded / e.total * 100);
                            };

                            xhr.onload = function() {
                                if (xhr.status === 403) {
                                    reject({ message: 'HTTP Error: ' + xhr.status, remove: true });
                                    return;
                                }
                                if (xhr.status < 200 || xhr.status >= 300) {
                                    reject('HTTP Error: ' + xhr.status);
                                    return;
                                }
                                const json = JSON.parse(xhr.responseText);
                                if (!json || typeof json.location != 'string') {
                                    reject('Invalid JSON: ' + xhr.responseText);
                                    return;
                                }
                                resolve(json.location);
                            };
                            
                            xhr.onerror = function () {
                                reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
                            };

                            const formData = new FormData();
                            formData.append('file', blobInfo.blob(), blobInfo.filename());

                            xhr.send(formData);
                        });
                    }
                });
            } else {
                console.error("TinyMCE not loaded!");
            }
        };

        // Initialize editor
        initMCE('#methodologyEditor');
    });
</script>
@endsection
