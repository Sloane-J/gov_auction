<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Welcome') }} - {{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#171717] text-gray-100 font-sans antialiased">

    {{-- Nav --}}
    @if (Route::has('login'))
        <nav class="fixed top-0 left-0 right-0 z-50 bg-[#171717]/95 backdrop-blur border-b border-gray-800" role="navigation" aria-label="Main navigation">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <a href="/" class="text-xl font-bold tracking-tight text-white" aria-label="Homepage">
                        GovAuction
                    </a>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('auctions.index') }}" class="text-sm font-medium text-gray-300 hover:text-white transition px-3 py-2 rounded-lg hover:bg-white/5" aria-label="Browse all auctions">Auctions</a>
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-300 hover:text-white transition px-4 py-2 rounded-full border border-gray-700 hover:border-gray-500">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-300 hover:text-white transition px-3 py-2 rounded-lg hover:bg-white/5">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="text-sm font-medium bg-white text-[#171717] px-4 py-2 rounded-full hover:bg-gray-200 transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">Register</a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    @endif

    {{-- Spacer for fixed nav --}}
    <div class="pt-16"></div>

    {{-- Hero --}}
    <section class="px-6 py-20 sm:py-28 lg:py-36" aria-labelledby="hero-heading">
        <div class="mx-auto max-w-7xl">
            <div class="max-w-3xl">
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-gray-400 mb-6">Government Auction Platform</p>
                <h1 id="hero-heading" class="text-4xl sm:text-5xl lg:text-6xl font-bold tracking-tight text-white leading-[1.1]">Bid on surplus & confiscated items.</h1>
                <p class="mt-6 text-lg sm:text-xl text-gray-400 leading-relaxed max-w-2xl">Browse live auctions from government agencies. Place your bid, track items, and win — all in one place.</p>
                <div class="mt-10 flex flex-wrap gap-4">
                    <a href="{{ route('auctions.index') }}" class="inline-flex items-center rounded-full bg-white px-8 py-3.5 text-sm font-semibold text-[#171717] transition hover:bg-gray-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">Browse Auctions</a>
                    @guest
                        <a href="{{ route('register') }}" class="inline-flex items-center rounded-full border border-gray-700 px-8 py-3.5 text-sm font-semibold text-white transition hover:bg-white/5 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">Create Account</a>
                    @endguest
                </div>
            </div>
        </div>
    </section>

    {{-- Auction Sections --}}
    <livewire:homepage-auctions />

    {{-- Footer --}}
    <footer class="border-t border-gray-800 mt-20" role="contentinfo">
        <div class="mx-auto max-w-7xl px-6 py-12 lg:py-16">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
                <p class="text-sm text-gray-500">&copy; {{ date('Y') }} GovAuction. All rights reserved.</p>
                <div class="flex gap-6">
                    <a href="#" class="text-sm text-gray-500 hover:text-gray-300 transition">Terms</a>
                    <a href="#" class="text-sm text-gray-500 hover:text-gray-300 transition">Privacy</a>
                    <a href="#" class="text-sm text-gray-500 hover:text-gray-300 transition">Contact</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
