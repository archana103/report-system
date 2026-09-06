<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>{{ $seo['title'] ?? 'Admin Panel | Epignosis Insights' }}</title>
    
    <!-- Using Tailwind CSS as per original layout -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- TinyMCE -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js" referrerpolicy="origin"></script>
    
    <style>
        .fade-enter-active,
        .fade-leave-active {
            transition: opacity 0.25s ease, transform 0.25s ease;
        }

        .fade-enter-from,
        .fade-leave-to {
            opacity: 0;
            transform: translateY(15px);
        }

        .router-active-item::before {
            content: '';
            position: absolute;
            left: -24px;
            top: 50%;
            transform: translateY(-50%);
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background-color: #818cf8; /* indigo-400 */
            box-shadow: 0 0 10px #818cf8;
        }

        /* Hide TinyMCE API Key Notification */
        .tox-notifications-container {
            display: none !important;
        }
        
        /* Custom scrollbar for webkit */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #0f172a;
        }
        ::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #475569;
        }
    </style>
</head>
<body class="bg-[#0f172a] text-white font-sans selection:bg-indigo-500 selection:text-white overflow-hidden">
    <div class="flex h-screen w-full">
        <!-- Leftbar (Sidebar) -->
        <aside class="w-64 flex flex-col bg-gradient-to-b from-gray-900 to-gray-800 border-r border-gray-700 shadow-2xl transition-all duration-300 relative z-20 flex-shrink-0">
            <div class="p-6 flex items-center justify-center border-b border-gray-700">
                <a href="{{ url('/admin/dashboard') }}">
                    <h2 class="text-2xl font-medium bg-clip-text text-transparent bg-gradient-to-r from-indigo-400 to-purple-500 tracking-wide uppercase">
                        Admin Panel
                    </h2>
                </a>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-3 overflow-y-auto">
                {{-- Dashboard --}}
                <a
                    href="{{ url('/admin/dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 border relative overflow-hidden group {{ request()->is('admin/dashboard') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 shadow-lg border-transparent text-white ring-1 ring-white/20' : 'border-transparent hover:border-gray-700 text-gray-200' }}"
                >
                    <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/5 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                    <svg class="w-5 h-5 {{ request()->is('admin/dashboard') ? 'text-white' : 'text-indigo-300' }} relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span class="font-medium relative z-10 text-white">Dashboard</span>
                </a>

                {{-- Master Accordion --}}
                @php
                    $isMasterActive = request()->is('admin/category-report') || request()->is('admin/category-list') || request()->is('admin/category-details');
                @endphp
                <div>
                    <button
                        onclick="toggleMenu('masterMenu', 'masterIcon')"
                        class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 border group {{ $isMasterActive ? 'bg-white/5 border-gray-700' : 'border-transparent hover:border-gray-700' }}"
                    >
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-indigo-300 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            <span class="font-medium text-white transition-colors">Reports</span>
                        </div>
                        <svg id="masterIcon" class="w-4 h-4 text-gray-300 group-hover:text-white transition-transform duration-300 transform {{ $isMasterActive ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div
                        id="masterMenu"
                        class="mt-3 space-y-1 overflow-hidden relative"
                        style="display: {{ $isMasterActive ? 'block' : 'none' }};"
                    >
                        <div class="absolute left-6 top-0 bottom-0 w-px bg-gray-700"></div>

                        <a href="{{ url('/admin/category-report') }}" class="relative flex items-center px-12 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->is('admin/category-report') ? 'text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400 font-medium !text-indigo-400 router-active-item' : 'text-white hover:text-white hover:bg-white/5' }}">Report Category</a>
                        <a href="{{ url('/admin/category-list') }}" class="relative flex items-center px-12 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->is('admin/category-list') ? 'text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400 font-medium !text-indigo-400 router-active-item' : 'text-white hover:text-white hover:bg-white/5' }}">Report List</a>
                        <a href="{{ url('/admin/category-details') }}" class="relative flex items-center px-12 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->is('admin/category-details') ? 'text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400 font-medium !text-indigo-400 router-active-item' : 'text-white hover:text-white hover:bg-white/5' }}">Report Details</a>
                    </div>
                </div>

                {{-- Report Management Accordion --}}
                @php
                    $isReportMgmtActive = request()->is('admin/top-selling-reports') || request()->is('admin/report-methodology');
                @endphp
                <div>
                    <button
                        onclick="toggleMenu('reportMgmtMenu', 'reportMgmtIcon')"
                        class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 border group {{ $isReportMgmtActive ? 'bg-white/5 border-gray-700' : 'border-transparent hover:border-gray-700' }}"
                    >
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-indigo-300 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            <span class="font-medium text-white transition-colors">USP</span>
                        </div>
                        <svg id="reportMgmtIcon" class="w-4 h-4 text-gray-300 group-hover:text-white transition-transform duration-300 transform {{ $isReportMgmtActive ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div
                        id="reportMgmtMenu"
                        class="mt-3 space-y-1 overflow-hidden relative"
                        style="display: {{ $isReportMgmtActive ? 'block' : 'none' }};"
                    >
                        <div class="absolute left-6 top-0 bottom-0 w-px bg-gray-700"></div>

                        <a href="{{ url('/admin/top-selling-reports') }}" class="relative flex items-center px-12 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->is('admin/top-selling-reports') ? 'text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400 font-medium !text-indigo-400 router-active-item' : 'text-white hover:text-white hover:bg-white/5' }}">Top Selling Reports</a>
                        <a href="{{ url('/admin/report-methodology') }}" class="relative flex items-center px-12 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->is('admin/report-methodology') ? 'text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400 font-medium !text-indigo-400 router-active-item' : 'text-white hover:text-white hover:bg-white/5' }}">Report Methodology</a>
                    </div>
                </div>

                {{-- Blogs Accordion --}}
                @php
                    $isBlogsActive = request()->is('admin/blogs') || request()->is('admin/blog-details') || request()->is('admin/blog-requests');
                @endphp
                <div>
                    <button
                        onclick="toggleMenu('blogsMenu', 'blogsIcon')"
                        class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 border group {{ $isBlogsActive ? 'bg-white/5 border-gray-700' : 'border-transparent hover:border-gray-700' }}"
                    >
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-indigo-300 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2"></path></svg>
                            <span class="font-medium text-white transition-colors">Blogs</span>
                        </div>
                        <svg id="blogsIcon" class="w-4 h-4 text-gray-300 group-hover:text-white transition-transform duration-300 transform {{ $isBlogsActive ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div
                        id="blogsMenu"
                        class="mt-3 space-y-1 overflow-hidden relative"
                        style="display: {{ $isBlogsActive ? 'block' : 'none' }};"
                    >
                        <div class="absolute left-6 top-0 bottom-0 w-px bg-gray-700"></div>

                        <a href="{{ url('/admin/blogs') }}" class="relative flex items-center px-12 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->is('admin/blogs') ? 'text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400 font-medium !text-indigo-400 router-active-item' : 'text-white hover:text-white hover:bg-white/5' }}">Blogs List</a>
                        <a href="{{ url('/admin/blog-details') }}" class="relative flex items-center px-12 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->is('admin/blog-details') ? 'text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400 font-medium !text-indigo-400 router-active-item' : 'text-white hover:text-white hover:bg-white/5' }}">Blog Details</a>
                        <a href="{{ url('/admin/blog-requests') }}" class="relative flex items-center px-12 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->is('admin/blog-requests') ? 'text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400 font-medium !text-indigo-400 router-active-item' : 'text-white hover:text-white hover:bg-white/5' }}">Blog Requests</a>
                    </div>
                </div>

                {{-- Contact Accordion --}}
                @php
                    $isContactActive = request()->is('admin/contact-us') || request()->is('admin/request-form') || request()->is('admin/newsletters');
                @endphp
                <div>
                    <button
                        onclick="toggleMenu('contactMenu', 'contactIcon')"
                        class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 border group {{ $isContactActive ? 'bg-white/5 border-gray-700' : 'border-transparent hover:border-gray-700' }}"
                    >
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-indigo-300 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span class="font-medium text-white transition-colors">Contact</span>
                        </div>
                        <svg id="contactIcon" class="w-4 h-4 text-gray-300 group-hover:text-white transition-transform duration-300 transform {{ $isContactActive ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div
                        id="contactMenu"
                        class="mt-3 space-y-1 overflow-hidden relative"
                        style="display: {{ $isContactActive ? 'block' : 'none' }};"
                    >
                        <div class="absolute left-6 top-0 bottom-0 w-px bg-gray-700"></div>

                        <a href="{{ url('/admin/contact-us') }}" class="relative flex items-center px-12 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->is('admin/contact-us') ? 'text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400 font-medium !text-indigo-400 router-active-item' : 'text-white hover:text-white hover:bg-white/5' }}">Contact Us Data</a>
                        <a href="{{ url('/admin/request-form') }}" class="relative flex items-center px-12 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->is('admin/request-form') ? 'text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400 font-medium !text-indigo-400 router-active-item' : 'text-white hover:text-white hover:bg-white/5' }}">Request Form Data</a>
                        <a href="{{ url('/admin/newsletters') }}" class="relative flex items-center px-12 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->is('admin/newsletters') ? 'text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400 font-medium !text-indigo-400 router-active-item' : 'text-white hover:text-white hover:bg-white/5' }}">Newsletter Data</a>
                    </div>
                </div>

                {{-- Lead Data Accordion --}}
                @php
                    $isLeadDataActive = request()->is('admin/pricing-setup') || request()->is('admin/purchases');
                @endphp
                <div>
                    <button
                        onclick="toggleMenu('leadDataMenu', 'leadDataIcon')"
                        class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 border group {{ $isLeadDataActive ? 'bg-white/5 border-gray-700' : 'border-transparent hover:border-gray-700' }}"
                    >
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-indigo-300 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <span class="font-medium text-white transition-colors">Lead Data</span>
                        </div>
                        <svg id="leadDataIcon" class="w-4 h-4 text-gray-300 group-hover:text-white transition-transform duration-300 transform {{ $isLeadDataActive ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div
                        id="leadDataMenu"
                        class="mt-3 space-y-1 overflow-hidden relative"
                        style="display: {{ $isLeadDataActive ? 'block' : 'none' }};"
                    >
                        <div class="absolute left-6 top-0 bottom-0 w-px bg-gray-700"></div>

                        <a href="{{ url('/admin/pricing-setup') }}" class="relative flex items-center px-12 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->is('admin/pricing-setup') ? 'text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400 font-medium !text-indigo-400 router-active-item' : 'text-white hover:text-white hover:bg-white/5' }}">Global Pricing</a>
                        <a href="{{ url('/admin/purchases') }}" class="relative flex items-center px-12 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->is('admin/purchases') ? 'text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400 font-medium !text-indigo-400 router-active-item' : 'text-white hover:text-white hover:bg-white/5' }}">Purchases</a>
                    </div>
                </div>

                {{-- Press Release Accordion --}}
                @php
                    $isPressReleaseActive = request()->is('admin/press-release') || request()->is('admin/press-release-details');
                @endphp
                <div>
                    <button
                        onclick="toggleMenu('pressReleaseMenu', 'pressReleaseIcon')"
                        class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 border group {{ $isPressReleaseActive ? 'bg-white/5 border-gray-700' : 'border-transparent hover:border-gray-700' }}"
                    >
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-indigo-300 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                            <span class="font-medium text-white transition-colors">Press Release</span>
                        </div>
                        <svg id="pressReleaseIcon" class="w-4 h-4 text-gray-300 group-hover:text-white transition-transform duration-300 transform {{ $isPressReleaseActive ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div
                        id="pressReleaseMenu"
                        class="mt-3 space-y-1 overflow-hidden relative"
                        style="display: {{ $isPressReleaseActive ? 'block' : 'none' }};"
                    >
                        <div class="absolute left-6 top-0 bottom-0 w-px bg-gray-700"></div>

                        <a href="{{ url('/admin/press-release') }}" class="relative flex items-center px-12 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->is('admin/press-release') ? 'text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400 font-medium !text-indigo-400 router-active-item' : 'text-white hover:text-white hover:bg-white/5' }}">Press Release List</a>
                        <a href="{{ url('/admin/press-release-details') }}" class="relative flex items-center px-12 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->is('admin/press-release-details') ? 'text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400 font-medium !text-indigo-400 router-active-item' : 'text-white hover:text-white hover:bg-white/5' }}">Press Release Details</a>
                    </div>
                </div>



                {{-- SEO Accordion --}}
                @php
                    $isSeoActive = request()->is('admin/page-seo');
                @endphp
                <div>
                    <button
                        onclick="toggleMenu('seoMenu', 'seoIcon')"
                        class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 hover:bg-white/5 border group {{ $isSeoActive ? 'bg-white/5 border-gray-700' : 'border-transparent hover:border-gray-700' }}"
                    >
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-indigo-300 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                            <span class="font-medium text-white transition-colors">SEO</span>
                        </div>
                        <svg id="seoIcon" class="w-4 h-4 text-gray-300 group-hover:text-white transition-transform duration-300 transform {{ $isSeoActive ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div
                        id="seoMenu"
                        class="mt-3 space-y-1 overflow-hidden relative"
                        style="display: {{ $isSeoActive ? 'block' : 'none' }};"
                    >
                        <div class="absolute left-6 top-0 bottom-0 w-px bg-gray-700"></div>

                        <a href="{{ url('/admin/page-seo') }}" class="relative flex items-center px-12 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->is('admin/page-seo') ? 'text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400 font-medium !text-indigo-400 router-active-item' : 'text-white hover:text-white hover:bg-white/5' }}">Page SEO</a>
                    </div>
                </div>
            </nav>

            <div class="p-4 border-t border-gray-700 bg-gray-900/50 mt-auto">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center font-medium shadow-lg ring-2 ring-gray-800">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm font-medium">{{ auth()->user()->name ?? 'Administrator' }}</p>
                        <p class="text-xs text-gray-500">View Profile</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Rightbar (Main Area) -->
        <main class="flex-1 overflow-auto bg-[#0b1121] relative flex flex-col w-full h-full">
            <!-- Subtle Background Glow -->
            <div class="fixed top-0 left-64 right-0 h-96 bg-indigo-900/10 blur-[120px] pointer-events-none rounded-full"></div>

            <header class="h-16 border-b border-gray-800 bg-[#0f172a]/80 backdrop-blur-md sticky top-0 z-[60] flex items-center justify-between px-6 shadow-sm flex-shrink-0">
                <h1 class="text-lg text-gray-300 font-medium">@yield('header_title', 'Dashboard Overview')</h1>

                <!-- Profile dropdown -->
                <div class="relative">
                    <button 
                        onclick="toggleProfileDropdown()"
                        class="flex items-center gap-2 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 rounded-xl p-1 transition-all"
                    >
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center font-bold text-white shadow ring-2 ring-gray-800">
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <span class="text-sm font-medium text-gray-300 hover:text-white hidden sm:inline">{{ auth()->user()->name ?? 'Administrator' }}</span>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div 
                        id="profileDropdown"
                        class="absolute right-0 mt-3 w-72 bg-gray-900 border border-gray-800 rounded-2xl shadow-2xl p-5 z-[100] text-left transform transition-all flex flex-col gap-4"
                        style="display: none;"
                    >
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center font-bold text-xl text-white shadow-lg ring-2 ring-gray-800">
                                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-base font-semibold text-gray-200">{{ auth()->user()->name ?? 'Administrator' }}</p>
                                <p class="text-xs text-gray-500">Member since {{ optional(auth()->user()->created_at)->format('M Y') ?? 'May 2026' }}</p>
                            </div>
                        </div>

                        <div class="flex justify-between items-center border-t border-gray-800 pt-3">
                            <a 
                                href="{{ url('/admin/change-password') }}" 
                                class="px-4 py-2 text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-500 rounded-xl shadow-lg shadow-indigo-500/20 transition-all focus:outline-none"
                            >
                                Change Password
                            </a>
                            <form action="{{ url('/admin/logout') }}" method="POST" class="inline">
                                @csrf
                                <button 
                                    type="submit"
                                    class="px-4 py-2 text-xs font-medium text-white bg-rose-600 hover:bg-rose-500 rounded-xl shadow-lg shadow-rose-500/20 transition-all focus:outline-none"
                                >
                                    Sign out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <div class="flex-1 p-5 relative z-10 w-full max-w-full mx-auto">
                @if (session('success'))
                    <div class="admin-alert mb-4 bg-emerald-500/10 border border-emerald-500/50 text-emerald-500 px-4 py-3 rounded-lg text-sm font-medium transition-opacity duration-500">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="admin-alert mb-4 bg-rose-500/10 border border-rose-500/50 text-rose-500 px-4 py-3 rounded-lg text-sm font-medium transition-opacity duration-500">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <script>
        function toggleMenu(menuId, iconId) {
            const menu = document.getElementById(menuId);
            const icon = document.getElementById(iconId);
            
            const isOpen = menu.style.display === 'block';

            // Close all
            const allMenus = [
                { id: 'masterMenu', icon: 'masterIcon' },
                { id: 'reportMgmtMenu', icon: 'reportMgmtIcon' },
                { id: 'blogsMenu', icon: 'blogsIcon' },
                { id: 'contactMenu', icon: 'contactIcon' },
                { id: 'leadDataMenu', icon: 'leadDataIcon' },
                { id: 'pressReleaseMenu', icon: 'pressReleaseIcon' },
                { id: 'seoMenu', icon: 'seoIcon' }
            ];

            allMenus.forEach(item => {
                const m = document.getElementById(item.id);
                const i = document.getElementById(item.icon);
                if (m && i) {
                    m.style.display = 'none';
                    i.classList.remove('rotate-180');
                }
            });

            // If it wasn't open, open it now
            if (!isOpen) {
                menu.style.display = 'block';
                icon.classList.add('rotate-180');
            }
        }

        function toggleProfileDropdown() {
            const dropdown = document.getElementById('profileDropdown');
            if (dropdown.style.display === 'none' || dropdown.style.display === '') {
                dropdown.style.display = 'flex';
            } else {
                dropdown.style.display = 'none';
            }
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('profileDropdown');
            const targetElement = event.target; // clicked element

            if (dropdown.style.display === 'flex') {
                if (!targetElement.closest('.relative')) {
                    dropdown.style.display = 'none';
                }
            }
        });

        // Auto-dismiss alerts after 10 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.admin-alert');
            if(alerts.length > 0) {
                setTimeout(() => {
                    alerts.forEach(alert => {
                        alert.style.opacity = '0';
                        setTimeout(() => alert.style.display = 'none', 200);
                    });
                }, 10000);
            }
        });
    </script>
    
    @yield('scripts')
</body>
</html>
