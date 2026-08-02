<!DOCTYPE html>
<html>
<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-2V5TKH8CZ4"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-2V5TKH8CZ4');
    </script>
    <meta name="google-site-verification" content="JKuXuLnNmtSufvAAso17wJtjoscQvNJB8sMU3G8JkE4" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ $seo['title'] ?? 'Research Report System' }}</title>
    
    @if(!empty($seo['description']))
    <meta name="description" content="{{ $seo['description'] }}">
    @endif
    @if(!empty($seo['keywords']))
    <meta name="keywords" content="{{ $seo['keywords'] }}">
    @endif
    @if(!empty($seo['robots']))
    <meta name="robots" content="{{ $seo['robots'] }}">
    @endif
    @if(!empty($seo['canonical']))
    <link rel="canonical" href="{{ $seo['canonical'] }}">
    @endif
    @if(!empty($seo['title']))
    <meta name="title" content="{{ $seo['title'] }}">
    @endif
    @if(!empty($seo['raw_head']))
    {!! $seo['raw_head'] !!}
    @endif
    
    @if(request()->is('/'))
    <link rel="preload" as="image" href="/assets/images/hero-bg-screenshot.png" fetchpriority="high">
    @endif

    <link rel="icon" type="image/png" href="/favicon.png?v=3.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css'])
</head>
<body class="home-page">

    @include('partials.header')

    <main class="main-content">
        @yield('content')
    </main>

    @include('partials.footer')

</body>
</html>
