<!DOCTYPE html>
<html lang="{{ session('customer_locale') ?? global_setting()->locale }}" dir="{{ session('customer_is_rtl') ? 'rtl' : 'ltr' }}">

<head>
    <link rel="manifest" href="{{ asset('manifest.json') }}" crossorigin="use-credentials">
    <meta name="theme-color" content="#ffffff">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- FAVICONS --}}
    <link rel="apple-touch-icon" sizes="180x180" href="{{ global_setting()->upload_fav_icon_apple_touch_icon_url }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ global_setting()->upload_fav_icon_android_chrome_192_url }}">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ global_setting()->upload_fav_icon_android_chrome_512_url }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ global_setting()->upload_fav_icon_16_url }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ global_setting()->upload_fav_icon_32_url }}">
    <link rel="shortcut icon" href="{{ global_setting()->favicon_url }}">


    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ global_setting()->logoUrl }}">

    {{-- META TAGS --}}
    <meta name="keywords" content="{{ global_setting()->meta_keyword ?? global_setting()->name }}">
    <meta name="description" content="{{ global_setting()->meta_description ?? global_setting()->name }}">

    @php
        $landingMetaTitle = global_setting()->meta_title ?? global_setting()->name;
        $landingMetaImage = global_setting()->meta_image_url ?? global_setting()->upload_fav_icon_android_chrome_512_url;
    @endphp
    <meta property="og:title" content="{{ $landingMetaTitle }}">
    <meta property="og:image" content="{{ $landingMetaImage }}">
    <meta property="og:image:alt" content="{{ $landingMetaTitle }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $landingMetaTitle }}">
    <meta name="twitter:image" content="{{ $landingMetaImage }}">

    <title>{{ global_setting()->meta_title ?? global_setting()->name }}</title>

    <!-- Google Fonts: Montserrat, Poppins & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Tailwind CSS & Flowbite CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>

    <!-- Styles -->
    @livewireStyles

    <style>
        html, body {
            overflow-x: hidden;
        }
        /* Mobile Drawer Buttons */
        #mobile-menu-drawer .btn-drawer-signup {
          background-color: #00B692 !important;
          color: #ffffff !important;
          font-weight: 700 !important;
          display: block !important;
          width: 100% !important;
          text-align: center !important;
          padding: 14px 0 !important;
          border-radius: 12px !important;
          box-shadow: 0 4px 14px rgba(0, 182, 146, 0.3) !important;
          text-transform: uppercase !important;
          letter-spacing: 0.5px !important;
          font-size: 14px !important;
          border: none !important;
          text-decoration: none !important;
        }
        #mobile-menu-drawer .btn-drawer-signup:hover {
          background-color: #009c7d !important;
          color: #ffffff !important;
        }
        #mobile-menu-drawer .btn-drawer-login {
          background-color: transparent !important;
          color: #374151 !important;
          font-weight: 600 !important;
          display: block !important;
          width: 100% !important;
          text-align: center !important;
          padding: 12px 0 !important;
          border-radius: 12px !important;
          border: 1px solid #d1d5db !important;
          text-decoration: none !important;
        }
        html.dark #mobile-menu-drawer .btn-drawer-login {
          color: #e5e7eb !important;
          border-color: #4b5563 !important;
        }
        /* Mobile Drawer Text Colors in Dark & Light Mode */
        #mobile-menu-drawer a.drawer-nav-link {
          color: #1f2937 !important;
        }
        #mobile-menu-drawer a.drawer-nav-link:hover {
          color: #00b692 !important;
        }
        #mobile-menu-drawer a.drawer-nav-link.active-nav-link {
          color: #00b692 !important;
          font-weight: 700 !important;
        }
        html.dark #mobile-menu-drawer a.drawer-nav-link {
          color: #f3f4f6 !important;
        }
        html.dark #mobile-menu-drawer a.drawer-nav-link:hover {
          color: #00b692 !important;
        }
        html.dark #mobile-menu-drawer a.drawer-nav-link.active-nav-link {
          color: #00b692 !important;
          font-weight: 700 !important;
        }
        :root {
            --color-base: 0, 182, 146 !important;
            --theme-color: #00B692 !important;
        }
        .bg-skin-base {
            background-color: #00B692 !important;
        }
        .text-skin-base {
            color: #00B692 !important;
        }
        .border-skin-base {
            border-color: #00B692 !important;
        }
    </style>

    @include('sections.theme_style', [
        'baseColor' => global_setting()->theme_rgb,
        'baseColorHex' => global_setting()->theme_hex,
    ])

    @if (File::exists(public_path() . '/css/app-custom.css'))
    <link href="{{ asset('css/app-custom.css') }}" rel="stylesheet">
    @endif

    {{-- Include file for widgets if exist --}}
    @includeIf('sections.custom_script_landing')
</head>

<body class="font-sans antialiased dark:bg-gray-900">
    @include('sections.offline-banner')
    <div class="mx-auto max-w-lg lg:max-w-screen-xl min-h-svh shadow-md lg:shadow-none">
        <header class="lg:hidden">
            <nav class="bg-white border-gray-200 px-3 py-2.5 dark:bg-gray-800 dark:text-gray">
                <div class="flex flex-nowrap justify-between items-center w-full mx-auto">
                    <a href="{{ url('/') }}" class="flex items-center gap-2 app-logo min-w-0 shrink" style="display:inline-flex; align-items:center; text-decoration:none;">
                        <img src="{{ asset('img/logo.png') }}" class="w-[40px] h-[40px] object-contain rounded-md shrink-0" style="height:40px; width:40px; max-height:40px; max-width:40px; object-fit:contain; border-radius:6px; flex-shrink:0;" alt="ShreeSwarupOS Logo" />
                        <span class="logo-text shrink min-w-0 overflow-hidden text-ellipsis" style="font-size:clamp(14px, 4.5vw, 18px); font-family:'Montserrat', 'Plus Jakarta Sans', sans-serif; font-weight:900; letter-spacing:0.5px; text-transform:uppercase; display:inline-flex; align-items:center; line-height:1; margin-left:6px; white-space:nowrap;">
                            <span style="color:#00B692; font-weight:900;">SHREESWARUP</span><span style="color:#9CB080; font-weight:900;">OS</span>
                        </span>
                    </a>
                    <div class="flex flex-shrink-0 items-center gap-2">
                        @if (languages()->count() > 1)
                            @livewire('shop.languageSwitcher')
                        @endif

                        <button id="mobile-menu-toggle" type="button"
                            class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                            aria-controls="mobile-menu-drawer" aria-expanded="false">
                            <span class="sr-only">@lang('menu.openMainMenu')</span>
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </nav>
        </header>

        <!-- FULLSCREEN MOBILE OVERLAY MENU MATCHING REFERENCE DESIGN -->
        <div class="hidden fixed inset-0 z-[999999] bg-white dark:bg-gray-900 flex-col justify-between p-6 transition-all duration-300"
            id="mobile-menu-drawer" style="position:fixed; top:0; left:0; right:0; bottom:0; width:100%; height:100vh; z-index:999999;">
            <!-- Top Bar -->
            <div class="flex justify-between items-center shrink-0 border-b border-gray-100 dark:border-gray-800" style="padding-bottom: 18px; margin-bottom: 8px;">
                <a href="{{ url('/') }}" class="flex items-center gap-2.5 app-logo" style="text-decoration:none;">
                    <img src="{{ asset('img/logo.png') }}" style="height:36px; width:38px; object-fit:contain; border-radius:6px;" alt="ShreeSwarupOS Logo" />
                    <span style="font-size:18px; font-family:'Montserrat', 'Plus Jakarta Sans', sans-serif; font-weight:900; letter-spacing:0.5px; text-transform:uppercase; line-height:1;">
                        <span style="color:#00B692; font-weight:900;">SHREESWARUP</span><span style="color:#9CB080; font-weight:900;">OS</span>
                    </span>
                </a>
                <div class="flex items-center gap-2">
                    <button id="theme-toggle-drawer" type="button" aria-label="Toggle Theme" class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-yellow-400 flex items-center justify-center hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                        <svg id="theme-toggle-dark-icon-drawer" class="hidden w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                        <svg id="theme-toggle-light-icon-drawer" class="hidden w-5 h-5 text-yellow-400 dark:text-yellow-400" style="color: #facc15 !important;" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <button id="close-mobile-menu" type="button" class="w-10 h-10 rounded-xl bg-teal-50 dark:bg-gray-800 text-teal-600 dark:text-teal-400 flex items-center justify-center text-xl font-bold hover:bg-teal-100 dark:hover:bg-gray-700 transition">
                        ✕
                    </button>
                </div>
            </div>

            <!-- Menu Nav List (Clean dividers + font-medium like reference image) -->
            <div class="flex-1 overflow-y-auto py-2">
                <ul class="flex flex-col text-left">
                    <li class="border-b border-gray-100 dark:border-gray-800/60">
                        <a href="{{ url('/') }}" class="drawer-nav-link block py-3.5 text-[15px] font-semibold transition">@lang('menu.home')</a>
                    </li>
                    <li class="border-b border-gray-100 dark:border-gray-800/60">
                        <a href="{{ url('/') }}#features" class="drawer-nav-link block py-3.5 text-[15px] font-medium transition">@lang('landing.features')</a>
                    </li>
                    <li class="border-b border-gray-100 dark:border-gray-800/60">
                        <a href="{{ url('/') }}#pricing" class="drawer-nav-link block py-3.5 text-[15px] font-medium transition">@lang('landing.pricing')</a>
                    </li>
                    @php
                        $customMenu = App\Models\CustomMenu::orderBy('sort_order')->get();
                    @endphp
                    @foreach ($customMenu as $menu)
                        @if ($menu->is_active && $menu->position == 'header')
                            <li class="border-b border-gray-100 dark:border-gray-800/60">
                                <a href="{{ route('customMenu', ['slug' => $menu->menu_slug]) }}" class="drawer-nav-link block py-3.5 text-[15px] font-medium transition">
                                    {{ $menu->menu_name }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                    <li class="border-b border-gray-100 dark:border-gray-800/60">
                        <a href="{{ url('/') }}#user-faqs" class="drawer-nav-link block py-3.5 text-[15px] font-medium transition">FAQ</a>
                    </li>
                </ul>
            </div>

            <!-- Bottom Action Buttons (Always visible in Light & Dark mode) -->
            <div class="pt-4 pb-2 border-t border-gray-100 dark:border-gray-800 flex flex-col gap-3 shrink-0 mt-auto bg-white dark:bg-gray-900">
                <a href="{{ route('login') }}" wire:navigate class="btn-drawer-login">
                    @if (user())
                        @lang('menu.dashboard')
                    @else
                        @lang('app.login')
                    @endif
                </a>
                <a href="{{ route('restaurant_signup') }}" wire:navigate class="btn-drawer-signup" style="background-color:#00B692 !important; color:#ffffff !important; font-weight:700 !important; display:block !important; width:100% !important; text-align:center !important; padding:14px 0 !important; border-radius:12px !important; text-transform:uppercase !important; text-decoration:none !important;">
                    @lang('landing.getStarted')
                </a>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const toggleBtn = document.getElementById('mobile-menu-toggle');
                const mobileMenu = document.getElementById('mobile-menu-drawer');
                const closeBtn = document.getElementById('close-mobile-menu');

                if (toggleBtn && mobileMenu) {
                    toggleBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        mobileMenu.classList.remove('hidden');
                        mobileMenu.style.display = 'flex';
                        document.body.style.overflow = 'hidden';
                    });
                }

                if (closeBtn && mobileMenu) {
                    closeBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        mobileMenu.classList.add('hidden');
                        mobileMenu.style.display = 'none';
                        document.body.style.overflow = '';
                    });
                }

                if (mobileMenu) {
                    mobileMenu.querySelectorAll('a').forEach(link => {
                        link.addEventListener('click', function() {
                            mobileMenu.classList.add('hidden');
                            mobileMenu.style.display = 'none';
                            document.body.style.overflow = '';
                        });
                    });
                }

                const darkIconMobile = document.getElementById('theme-toggle-dark-icon-mobile');
                const lightIconMobile = document.getElementById('theme-toggle-light-icon-mobile');
                const btnMobile = document.getElementById('theme-toggle-mobile');

                const darkIconDrawer = document.getElementById('theme-toggle-dark-icon-drawer');
                const lightIconDrawer = document.getElementById('theme-toggle-light-icon-drawer');
                const btnDrawer = document.getElementById('theme-toggle-drawer');

                function updateThemeUI() {
                    const isDark = document.documentElement.classList.contains('dark') || localStorage.getItem('color-theme') === 'dark';
                    [
                        { dark: darkIconMobile, light: lightIconMobile },
                        { dark: darkIconDrawer, light: lightIconDrawer }
                    ].forEach(pair => {
                        if (pair.dark && pair.light) {
                            if (isDark) {
                                pair.light.classList.remove('hidden');
                                pair.dark.classList.add('hidden');
                            } else {
                                pair.dark.classList.remove('hidden');
                                pair.light.classList.add('hidden');
                            }
                        }
                    });
                }

                function toggleTheme() {
                    if (document.documentElement.classList.contains('dark')) {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('color-theme', 'light');
                    } else {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('color-theme', 'dark');
                    }
                    updateThemeUI();
                }

                if (btnMobile) btnMobile.addEventListener('click', toggleTheme);
                if (btnDrawer) btnDrawer.addEventListener('click', toggleTheme);
                updateThemeUI();
            });
        </script>

        <header class="hidden lg:block z-50 sticky top-0 inset-x-0">
            <nav class="bg-white border-gray-200 px-4 lg:px-6 py-2.5 dark:bg-gray-800 sticky top-4 rounded-md mt-2 ">
                <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
                    <a href="{{ url('/') }}" class="flex items-center gap-3 app-logo" style="display:inline-flex; align-items:center; text-decoration:none;">
                        <img src="{{ asset('img/logo.png') }}" class="w-[52px] h-[52px] object-contain rounded-md shrink-0 shadow-sm" style="height:52px; width:52px; max-height:52px; max-width:52px; object-fit:contain; border-radius:6px; flex-shrink:0;" alt="ShreeSwarupOS Logo" />
                        <span class="logo-text" style="font-size:22px; font-family:'Montserrat', 'Plus Jakarta Sans', sans-serif; font-weight:900; letter-spacing:0.5px; text-transform:uppercase; display:inline-flex; align-items:center; line-height:1; margin-left:12px;">
                            <span style="color:#00B692; font-weight:900;">SHREESWARUP</span><span style="color:#9CB080; font-weight:900;">OS</span>
                        </span>
                    </a>
                    <div class="flex items-center lg:order-2">
                        <button id="theme-toggle" data-tooltip-target="tooltip-toggle" type="button"
                            class=" text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 ltr:mr-4 rtl:ml-4">
                            <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 0 1 6.707 2.707a8.001 8.001 0 1 0 10.586 10.586"/></svg>
                            <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 0 1 1 1v1a1 1 0 1 1-2 0V3a1 1 0 0 1 1-1m4 8a4 4 0 1 1-8 0 4 4 0 0 1 8 0m-.464 4.95.707.707a1 1 0 0 0 1.414-1.414l-.707-.707a1 1 0 0 0-1.414 1.414m2.12-10.607a1 1 0 0 1 0 1.414l-.706.707a1 1 0 1 1-1.414-1.414l.707-.707a1 1 0 0 1 1.414 0zM17 11a1 1 0 1 0 0-2h-1a1 1 0 1 0 0 2zm-7 4a1 1 0 0 1 1 1v1a1 1 0 1 1-2 0v-1a1 1 0 0 1 1-1M5.05 6.464A1 1 0 1 0 6.465 5.05l-.708-.707a1 1 0 0 0-1.414 1.414zm1.414 8.486-.707.707a1 1 0 0 1-1.414-1.414l.707-.707a1 1 0 0 1 1.414 1.414M4 11a1 1 0 1 0 0-2H3a1 1 0 0 0 0 2z" fill-rule="evenodd" clip-rule="evenodd"/></svg>
                        </button>
                        <div id="tooltip-toggle" role="tooltip"
                            class="hidden absolute z-10 invisible px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip">
                            Toggle dark mode
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>

                        <a href="{{ route('login') }}"
                            class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-lg font-semibold text-sm text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150 ltr:pl-4 rtl:pr-4"
                            wire:click="$dispatch('showSignup')">
                            @if (user())
                                @lang('menu.dashboard')
                            @else
                                @lang('app.login')
                            @endif
                        </a>

                        @if (!user())
                            <a href="{{ route('restaurant_signup') }}"
                                class="text-white justify-center bg-skin-base hover:bg-skin-base/[.8] sm:w-auto dark:bg-skin-base dark:hover:bg-skin-base/[0.7] font-semibold rounded-lg text-sm px-5 py-2.5 text-center ltr:ml-2 rtl:mr-2"
                                wire:click="$dispatch('showSignup')">@lang('landing.getStarted')</a>
                        @endif
                        <button id="desktop-menu-toggle" type="button"
                            class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                            <span class="sr-only">@lang('menu.openMainMenu')</span>
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="hidden justify-between items-center w-full lg:flex lg:w-auto lg:order-1"
                        id="desktop-menu-2">
                        <ul
                            class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0 rtl:space-x-reverse">
                            <li>
                                <a href="{{ url('/') }}" wire:navigate @class([
                                    'block py-2 pr-4 pl-3 rounded bg-red-700 lg:bg-transparent lg:p-0',
                                    'dark:text-white text-gray-700' => !request()->routeIs(['home']),
                                    'dark:text-skin-base text-skin-base' => request()->routeIs(['home']),
                                ])
                                    aria-current="page">@lang('menu.home')</a>
                            </li>

                            <li>
                                <a href="{{ url('/') }}#icon-features" @class([
                                    'transition-all duration-300 block py-2 pr-4 pl-3 rounded lg:bg-transparent lg:p-0 text-gray-700 dark:text-white',
                                ])
                                    aria-current="page">@lang('landing.features')</a>
                            </li>

                            <li>
                                <a href="{{ url('/') }}#simple-pricing" @class([
                                    'transition-all duration-300 block py-2 pr-4 pl-3 rounded lg:bg-transparent lg:p-0 text-gray-700 dark:text-white',
                                ])
                                    aria-current="page">@lang('landing.pricing')</a>
                            </li>

                            <li>
                                <a href="{{ url('/') }}#user-faqs" @class([
                                    'transition-all duration-300 block py-2 pr-4 pl-3 rounded lg:bg-transparent lg:p-0 text-gray-700 dark:text-white',
                                ])
                                    aria-current="page">@lang('landing.faq')</a>
                            </li>

                            @foreach ($customMenu as $menu)
                                @if ($menu->is_active && $menu->position == 'header')
                                    <li>
                                        <a href="{{ route('customMenu', ['slug' => $menu->menu_slug]) }}" @class([
                                            'transition-all duration-300 block py-2 pr-4 pl-3 rounded lg:bg-transparent lg:p-0 text-gray-700 dark:text-white',
                                        ])
                                            aria-current="page">
                                            {{ $menu->menu_name }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <div class="flex mt-0 overflow-hidden dark:bg-gray-900">
            <div id="main-content" class="w-full h-full overflow-y-auto dark:bg-gray-900">
                <main>
                    @yield('content')
                    {{ $slot ?? '' }}
                </main>
            </div>
        </div>
    </div>
    @stack('modals')
    <footer class="p-2 bg-white sm:p-3 dark:bg-gray-800 border-t dark:border-gray-600">
        <div class="mx-auto max-w-screen-xl">
            <div class="sm:flex sm:items-center sm:justify-between flex-wrap gap-4">
                <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© {{ now()->year }} <a
                        href="" class="hover:underline">{{ global_setting()->name }}</a>. @lang('landing.rightsReserved')
                </span>
                <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0 rtl:space-x-reverse">
                    @foreach ($customMenu as $menu)
                        @if ($menu->is_active && $menu->position == 'footer')
                            <li>
                                <a href="{{ route('customMenu', ['slug' => $menu->menu_slug]) }}" @class([
                                    'transition-all duration-300 block py-2 pr-4 pl-3 rounded lg:bg-transparent lg:p-0 text-gray-700 dark:text-white',
                                ])
                                    aria-current="page">
                                    {{ $menu->menu_name }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
                <div class="flex mt-4 space-x-6 sm:justify-center sm:mt-0 rtl:space-x-reverse items-center">
                    @if (languages()->count() > 1)
                        <span class="inline-flex items-center leading-none text-gray-500 hover:text-gray-900 dark:hover:text-white">
                            @livewire('shop.languageSwitcher')
                        </span>
                    @endif

                    @if (global_setting()->facebook_link)
                        <a href="{{ global_setting()->facebook_link }}"
                            class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif

                    @if (global_setting()->instagram_link)
                        <a href="{{ global_setting()->instagram_link }}"
                            class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif

                    @if (global_setting()->twitter_link)
                        <a href="{{ global_setting()->twitter_link }}"
                            class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 50 50 " aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100"
                                viewBox="0 0 50 50">
                                <path
                                    d="M 6.9199219 6 L 21.136719 26.726562 L 6.2285156 44 L 9.40625 44 L 22.544922 28.777344 L 32.986328 44 L 43 44 L 28.123047 22.3125 L 42.203125 6 L 39.027344 6 L 26.716797 20.261719 L 16.933594 6 L 6.9199219 6 z">
                                </path>
                            </svg>
                        </a>
                    @endif

                    @if (global_setting()->yelp_link)
                        <a href="{{ global_setting()->yelp_link }}"
                            class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 30 30" aria-hidden="true">
                                <path
                                    d="M13.961 22.279c0.246-0.273 0.601-0.444 0.995-0.444 0.739 0 1.338 0.599 1.338 1.338 0 0.016-0 0.032-0.001 0.048l0-0.002-0.237 6.483c-0.027 0.719-0.616 1.293-1.34 1.293-0.077 0-0.153-0.006-0.226-0.019l0.008 0.001c-1.763-0.303-3.331-0.962-4.69-1.902l0.039 0.025c-0.351-0.245-0.578-0.647-0.578-1.102 0-0.346 0.131-0.661 0.346-0.898l-0.001 0.001 4.345-4.829zM12.853 20.434l-6.301 1.572c-0.097 0.025-0.208 0.039-0.322 0.039-0.687 0-1.253-0.517-1.332-1.183l-0.001-0.006c-0.046-0.389-0.073-0.839-0.073-1.295 0-1.324 0.223-2.597 0.635-3.781l-0.024 0.081c0.183-0.534 0.681-0.911 1.267-0.911 0.214 0 0.417 0.050 0.596 0.14l-0.008-0.004 5.833 2.848c0.45 0.221 0.754 0.677 0.754 1.203 0 0.623-0.427 1.147-1.004 1.294l-0.009 0.002zM13.924 15.223l-6.104-10.574c-0.112-0.191-0.178-0.421-0.178-0.667 0-0.529 0.307-0.987 0.752-1.204l0.008-0.003c1.918-0.938 4.153-1.568 6.511-1.761l0.067-0.004c0.031-0.003 0.067-0.004 0.104-0.004 0.738 0 1.337 0.599 1.337 1.337 0 0.001 0 0.001 0 0.002v-0 12.207c-0 0.739-0.599 1.338-1.338 1.338-0.493 0-0.923-0.266-1.155-0.663l-0.003-0.006zM19.918 20.681l6.176 2.007c0.541 0.18 0.925 0.682 0.925 1.274 0 0.209-0.048 0.407-0.134 0.584l0.003-0.008c-0.758 1.569-1.799 2.889-3.068 3.945l-0.019 0.015c-0.23 0.19-0.527 0.306-0.852 0.306-0.477 0-0.896-0.249-1.134-0.625l-0.003-0.006-3.449-5.51c-0.128-0.201-0.203-0.446-0.203-0.709 0-0.738 0.598-1.336 1.336-1.336 0.147 0 0.289 0.024 0.421 0.068l-0.009-0.003zM26.197 16.742l-6.242 1.791c-0.11 0.033-0.237 0.052-0.368 0.052-0.737 0-1.335-0.598-1.335-1.335 0-0.282 0.087-0.543 0.236-0.758l-0.003 0.004 3.63-5.383c0.244-0.358 0.65-0.59 1.111-0.59 0.339 0 0.649 0.126 0.885 0.334l-0.001-0.001c1.25 1.104 2.25 2.459 2.925 3.99l0.029 0.073c0.070 0.158 0.111 0.342 0.111 0.535 0 0.608-0.405 1.121-0.959 1.286l-0.009 0.002z">
                                </path>
                            </svg>
                        </a>
                    @endif
                    @if (global_setting()->google_business_link)
                        <a href="{{ global_setting()->google_business_link }}" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M21.35 11.1h-9.3v2.95h5.43c-.235 1.34-1.22 3.925-5.43 3.925-3.27 0-5.94-2.705-5.94-6.05s2.67-6.05 5.94-6.05c1.87 0 3.12.8 3.84 1.48l2.62-2.52C17.65 2.3 15.84 1.4 13.5 1.4 7.68 1.4 3 5.92 3 11.4s4.68 10 10.5 10c5.97 0 9.9-4.22 9.9-10 0-.67-.08-1.33-.05-1.7z"/>
                            </svg>
                        </a>
                    @endif

                </div>
            </div>
        </div>
    </footer>
    @livewireScripts

    @include('layouts.update-uri')

    @include('layouts.service-worker-js')

    @include('sections.pusher-script')

    <x-livewire-alert::flash />

    @stack('scripts')
</body>

</html>
