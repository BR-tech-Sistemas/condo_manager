<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <!-- OG Meta Tags to improve the way the post looks when you share the page on Facebook, Twitter, LinkedIn -->
    <meta property="og:site_name" content="" /> <!-- website name -->
    <meta property="og:site" content="" /> <!-- website link -->
    <meta property="og:title" content="" /> <!-- title shown in the actual shared post -->
    <meta property="og:description" content="" /> <!-- description shown in the actual shared post -->
    <meta property="og:image" content="" /> <!-- image link, make sure it's jpg -->
    <meta property="og:url" content="" /> <!-- where do you want your post to link to -->
    <meta name="twitter:card" content="summary_large_image" /> <!-- to have large image post format in Twitter -->

    <title>{{ $appName }}</title>

    <!-- Styles -->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet" />
    <link href="{{ asset('css/guest/fontawesome-all.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/guest/swiper.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/guest/magnific-popup.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/guest/styles.css') }}" rel="stylesheet" />

    @vite([
        'resources/js/app.js',
        'resources/css/app.css',
    ])

</head>
<body data-spy="scroll" data-target=".fixed-top">

{{ $slot }}

<!-- Scripts -->
<script src="{{ asset('js/guest/jquery.min.js') }}"></script> <!-- jQuery for JavaScript plugins -->
<script src="{{ asset('js/guest/jquery.easing.min.js') }}"></script> <!-- jQuery Easing for smooth scrolling between anchors -->
<script src="{{ asset('js/guest/swiper.min.js') }}"></script> <!-- Swiper for image and text sliders -->
<script src="{{ asset('js/guest/jquery.magnific-popup.js') }}"></script> <!-- Magnific Popup for lightboxes -->
<script src="{{ asset('js/guest/scripts.js') }}"></script> <!-- Scripts -->
</body>
</html>