<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventPortal — Discover Amazing Events</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300&family=DM+Mono:wght@400;500&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'DM Sans', sans-serif;
        }

        .mono {
            font-family: 'DM Mono', monospace;
        }

        .hero-gradient {
            background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
        }

        .card-hover {
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }

        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
            border-color: #a5b4fc;
        }

        .gradient-text {
            background: linear-gradient(135deg, #818cf8, #c084fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .badge-pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.6;
            }
        }

        .event-image-placeholder {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #db2777 100%);
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        .nav-blur {
            backdrop-filter: blur(12px);
            background: rgba(15, 12, 41, 0.85);
        }

        .section-divider {
            background: linear-gradient(90deg, transparent, #4f46e5, transparent);
            height: 1px;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800">

    {{-- ============ NAVBAR ============ --}}
    <nav class="nav-blur fixed top-0 left-0 right-0 z-50 border-b border-white/10">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-indigo-600 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z" />
                    </svg>
                </div>
                <span class="text-white font-semibold text-lg">EventPortal</span>
            </a>

            <div class="hidden md:flex items-center gap-8">
                <a href="#events"
                    class="text-slate-300 hover:text-white text-sm font-medium transition-colors">Events</a>
                <a href="#how-it-works"
                    class="text-slate-300 hover:text-white text-sm font-medium transition-colors">How It Works</a>
                <a href="#categories"
                    class="text-slate-300 hover:text-white text-sm font-medium transition-colors">Categories</a>
                <a href="#testimonials"
                    class="text-slate-300 hover:text-white text-sm font-medium transition-colors">Reviews</a>
            </div>

            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2.5 rounded-xl transition-colors">
                        Go to Dashboard →
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="text-slate-300 hover:text-white text-sm font-medium transition-colors">
                        Sign in
                    </a>
                    <a href="{{ route('register') }}"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2.5 rounded-xl transition-colors">
                        Get Started
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- ============ HERO ============ --}}
    <section class="hero-gradient min-h-screen flex items-center relative overflow-hidden pt-20">

        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-20 left-10 w-72 h-72 bg-indigo-600/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-purple-600/20 rounded-full blur-3xl"></div>
            <div
                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-indigo-900/30 rounded-full blur-3xl">
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 py-24 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

                <div>
                    <div
                        class="inline-flex items-center gap-2 bg-indigo-600/20 border border-indigo-500/30 text-indigo-300 text-xs font-semibold px-4 py-2 rounded-full mb-6">
                        <span class="w-2 h-2 bg-indigo-400 rounded-full badge-pulse"></span>
                        Tasmania's #1 Event Platform
                    </div>

                    <h1 class="text-5xl lg:text-6xl font-light text-white leading-tight mb-6">
                        Discover &amp;<br>
                        <span class="gradient-text font-semibold">Experience</span><br>
                        Amazing Events
                    </h1>

                    <p class="text-slate-300 text-lg leading-relaxed mb-8 max-w-lg">
                        From music festivals to tech conferences — find, book, and manage tickets for the best events
                        happening around you.
                    </p>

                    <div class="flex flex-wrap items-center gap-4 mb-10">
                        @guest
                            <a href="{{ route('register') }}"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-8 py-3.5 rounded-xl transition-colors text-base">
                                Browse Events →
                            </a>
                            <a href="{{ route('login') }}"
                                class="border border-white/20 hover:border-white/40 text-white font-medium px-8 py-3.5 rounded-xl transition-colors text-base">
                                Sign In
                            </a>
                        @else
                        <a href="{{ route('events.index') }}"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-8 py-3.5 rounded-xl transition-colors text-base">
                            Browse Events →
                        </a>
                        @endauth
                    </div>

                    <div class="flex items-center gap-8">
                        <div>
                            <p class="text-2xl font-bold text-white">{{ $stats['events'] }}+</p>
                            <p class="text-slate-400 text-sm">Live Events</p>
                        </div>
                        <div class="w-px h-10 bg-white/10"></div>
                        <div>
                            <p class="text-2xl font-bold text-white">{{ $stats['tickets'] }}+</p>
                            <p class="text-slate-400 text-sm">Tickets Sold</p>
                        </div>
                        <div class="w-px h-10 bg-white/10"></div>
                        <div>
                            <p class="text-2xl font-bold text-white">{{ $stats['organisers'] }}+</p>
                            <p class="text-slate-400 text-sm">Organisers</p>
                        </div>
                    </div>
                </div>

                <div class="hidden lg:block relative">
                    <div class="floating">
                        @if($featuredEvents->isNotEmpty())
                            <div
                                class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-5 mb-4 shadow-2xl">
                                <div class="flex items-center gap-3 mb-3">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-indigo-500 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-white font-semibold text-sm">
                                            {{ Str::limit($featuredEvents->first()->title, 30) }}</p>
                                        <p class="text-slate-400 text-xs">
                                            {{ $featuredEvents->first()->start_date->format('d M Y') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span
                                        class="text-indigo-300 text-xs mono">{{ $featuredEvents->first()->availableSpots() }}
                                        spots left</span>
                                    <span class="bg-indigo-600 text-white text-xs font-semibold px-3 py-1 rounded-full">
                                        {{ $featuredEvents->first()->isFree() ? 'Free' : '$' . number_format($featuredEvents->first()->price, 0) }}
                                    </span>
                                </div>
                            </div>
                        @endif

                        <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-4 ml-8">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="w-2 h-2 bg-emerald-400 rounded-full badge-pulse"></div>
                                <span class="text-emerald-400 text-xs font-semibold">Live Now — {{ $stats['events'] }}
                                    events available</span>
                            </div>
                            <p class="text-slate-400 text-xs">{{ $stats['tickets'] }} tickets purchased this season</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                <path d="M0 80L1440 80L1440 40C1200 80 960 0 720 20C480 40 240 80 0 40L0 80Z" fill="#f1f5f9" />
            </svg>
        </div>
    </section>

    {{-- ============ STATS BANNER ============ --}}
    <section class="bg-indigo-600 py-10">
        <div class="max-w-7xl mx-auto px-6">
            @php
                $statItems = [
                    ['icon' => '🎟', 'value' => $stats['tickets'] . '+', 'label' => 'Tickets Sold'],
                    ['icon' => '🎪', 'value' => $stats['events'] . '+', 'label' => 'Active Events'],
                    ['icon' => '👥', 'value' => $stats['users'] . '+', 'label' => 'Happy Attendees'],
                    ['icon' => '🏢', 'value' => $stats['organisers'] . '+', 'label' => 'Event Organisers'],
                ];
            @endphp
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                @foreach($statItems as $item)
                    <div>
                        <div class="text-3xl mb-1">{{ $item['icon'] }}</div>
                        <div class="text-3xl font-bold text-white">{{ $item['value'] }}</div>
                        <div class="text-indigo-200 text-sm mt-1">{{ $item['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============ FEATURED EVENTS ============ --}}
    <section id="events" class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6">

            <div class="flex items-end justify-between mb-12">
                <div>
                    <p class="text-indigo-600 text-sm font-semibold uppercase tracking-wider mb-2">Don't Miss Out</p>
                    <h2 class="text-4xl font-light text-slate-800">Upcoming <span class="font-semibold">Events</span>
                    </h2>
                </div>
                <a href="{{ route('events.index') }}"
                    class="hidden md:inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-700 font-medium text-sm">
                    View all events
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($featuredEvents as $event)
                    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden card-hover flex flex-col">

                        @if($event->image_path)
                            <img src="{{ Storage::url($event->image_path) }}" class="h-44 w-full object-cover"
                                alt="{{ $event->title }}">
                        @else
                            <div class="h-44 event-image-placeholder flex items-center justify-center relative">
                                <svg class="w-12 h-12 text-white/30" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5" />
                                </svg>
                                <div class="absolute top-3 right-3">
                                    <span
                                        class="bg-white/20 backdrop-blur text-white text-xs font-semibold px-3 py-1 rounded-full">
                                        {{ $event->isFree() ? 'Free' : '$' . number_format($event->price, 0) }}
                                    </span>
                                </div>
                            </div>
                        @endif

                        <div class="p-5 flex flex-col flex-1">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-semibold text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-full">
                                    {{ $event->start_date->format('d M Y') }}
                                </span>
                                @if($event->isSoldOut())
                                    <span class="text-xs font-semibold text-red-600 bg-red-50 px-2.5 py-1 rounded-full">Sold
                                        Out</span>
                                @else
                                    <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">
                                        {{ $event->availableSpots() }} spots left
                                    </span>
                                @endif
                            </div>

                            <h3 class="font-semibold text-slate-800 text-lg mb-1 leading-snug">{{ $event->title }}</h3>
                            <p class="text-slate-500 text-sm mb-3 flex-1">{{ Str::limit($event->description, 80) }}</p>

                            <div class="space-y-1.5 mb-4">
                                <div class="flex items-center gap-2 text-xs text-slate-400">
                                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                    </svg>
                                    {{ Str::limit($event->location, 40) }}
                                </div>
                                <div class="flex items-center gap-2 text-xs text-slate-400">
                                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                    </svg>
                                    by {{ $event->organiser->name }}
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="flex justify-between text-xs text-slate-400 mb-1">
                                    <span>{{ $event->soldCount() }} attending</span>
                                    <span>{{ $event->capacity }} capacity</span>
                                </div>
                                <div class="h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-indigo-500 rounded-full"
                                        style="width: {{ min(100, ($event->soldCount() / $event->capacity) * 100) }}%">
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="font-bold text-slate-800 text-lg">
                                    {{ $event->isFree() ? 'Free' : '$' . number_format($event->price, 2) }}
                                </span>
                                @auth
                                    <a href="{{ route('events.show', $event) }}"
                                        class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-5 py-2 rounded-xl transition-colors">
                                        {{ $event->isSoldOut() ? 'View Event' : 'Get Ticket' }}
                                    </a>
                                @else
                                    <a href="{{ route('register') }}"
                                        class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-5 py-2 rounded-xl transition-colors">
                                        {{ $event->isSoldOut() ? 'View Event' : 'Get Ticket' }}
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-16 text-slate-400">
                        <p class="text-lg">No upcoming events at the moment.</p>
                        <p class="text-sm mt-2">Check back soon!</p>
                    </div>
                @endforelse
            </div>

            <div class="text-center mt-10 md:hidden">
                <a href="{{ route('events.index') }}"
                    class="inline-flex items-center gap-2 bg-indigo-600 text-white font-medium px-6 py-3 rounded-xl">
                    View all events →
                </a>
            </div>
        </div>
    </section>

    {{-- ============ HOW IT WORKS ============ --}}
    <section id="how-it-works" class="py-20 bg-white">
        <div class="section-divider mb-20"></div>
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-14">
                <p class="text-indigo-600 text-sm font-semibold uppercase tracking-wider mb-2">Simple Process</p>
                <h2 class="text-4xl font-light text-slate-800">How It <span class="font-semibold">Works</span></h2>
                <p class="text-slate-500 mt-3 max-w-md mx-auto">Get your ticket in 3 easy steps</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                <div class="text-center">
                    <div
                        class="inline-flex w-16 h-16 rounded-2xl bg-indigo-100 text-indigo-600 items-center justify-center mb-5">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                        </svg>
                    </div>
                    <div class="mono text-xs font-medium text-slate-300 mb-2">STEP 01</div>
                    <h3 class="font-semibold text-slate-800 text-lg mb-2">Create Account</h3>
                    <p class="text-slate-500 text-sm leading-relaxed max-w-xs mx-auto">
                        Sign up in seconds. Choose whether you want to attend events or organise your own.
                    </p>
                </div>

                <div class="text-center">
                    <div
                        class="inline-flex w-16 h-16 rounded-2xl bg-purple-100 text-purple-600 items-center justify-center mb-5">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </div>
                    <div class="mono text-xs font-medium text-slate-300 mb-2">STEP 02</div>
                    <h3 class="font-semibold text-slate-800 text-lg mb-2">Find Your Event</h3>
                    <p class="text-slate-500 text-sm leading-relaxed max-w-xs mx-auto">
                        Browse hundreds of events by category, date, or location. Filter to find what excites you.
                    </p>
                </div>

                <div class="text-center">
                    <div
                        class="inline-flex w-16 h-16 rounded-2xl bg-emerald-100 text-emerald-600 items-center justify-center mb-5">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z" />
                        </svg>
                    </div>
                    <div class="mono text-xs font-medium text-slate-300 mb-2">STEP 03</div>
                    <h3 class="font-semibold text-slate-800 text-lg mb-2">Book &amp; Enjoy</h3>
                    <p class="text-slate-500 text-sm leading-relaxed max-w-xs mx-auto">
                        Purchase your ticket instantly and download your PDF. Present it at the door and enjoy!
                    </p>
                </div>

            </div>
        </div>
    </section>

    {{-- ============ CATEGORIES ============ --}}
    <section id="categories" class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-12">
                <p class="text-indigo-600 text-sm font-semibold uppercase tracking-wider mb-2">Something For Everyone
                </p>
                <h2 class="text-4xl font-light text-slate-800">Browse by <span class="font-semibold">Category</span>
                </h2>
            </div>

            @php
                $categories = [
                    ['emoji' => '🎵', 'label' => 'Music', 'classes' => 'bg-pink-50 border-pink-200 hover:bg-pink-100'],
                    ['emoji' => '💻', 'label' => 'Technology', 'classes' => 'bg-blue-50 border-blue-200 hover:bg-blue-100'],
                    ['emoji' => '🎨', 'label' => 'Arts', 'classes' => 'bg-purple-50 border-purple-200 hover:bg-purple-100'],
                    ['emoji' => '🍷', 'label' => 'Food & Drink', 'classes' => 'bg-amber-50 border-amber-200 hover:bg-amber-100'],
                    ['emoji' => '🏃', 'label' => 'Sports', 'classes' => 'bg-emerald-50 border-emerald-200 hover:bg-emerald-100'],
                    ['emoji' => '📚', 'label' => 'Education', 'classes' => 'bg-indigo-50 border-indigo-200 hover:bg-indigo-100'],
                ];
            @endphp

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach($categories as $cat)
                    <a href="{{ route('events.index') }}"
                        class="border rounded-2xl p-5 text-center transition-all cursor-pointer card-hover {{ $cat['classes'] }}">
                        <div class="text-3xl mb-2">{{ $cat['emoji'] }}</div>
                        <p class="text-sm font-semibold text-slate-700">{{ $cat['label'] }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============ ADVERTISEMENT BANNER ============ --}}
    <section class="py-16 bg-gradient-to-r from-indigo-900 via-indigo-800 to-purple-900 relative overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-0 left-0 w-64 h-64 bg-white/5 rounded-full -translate-x-1/2 -translate-y-1/2">
            </div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-white/5 rounded-full translate-x-1/3 translate-y-1/3">
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <span
                        class="inline-flex items-center gap-2 bg-white/10 text-white text-xs font-semibold px-4 py-2 rounded-full mb-5">
                        🔥 Limited Time Offer
                    </span>
                    <h2 class="text-4xl font-light text-white mb-4">
                        Organise Your Event<br>
                        <span class="font-bold">With Zero Hassle</span>
                    </h2>
                    <p class="text-indigo-200 text-base leading-relaxed mb-6">
                        Create, publish and manage your events with our powerful platform. Sell tickets, track
                        attendance, and grow your audience — all in one place.
                    </p>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('register') }}"
                            class="bg-white text-indigo-700 font-semibold px-7 py-3 rounded-xl hover:bg-indigo-50 transition-colors">
                            Start Organising →
                        </a>
                        <a href="{{ route('login') }}"
                            class="border border-white/30 text-white font-medium px-7 py-3 rounded-xl hover:bg-white/10 transition-colors">
                            Learn More
                        </a>
                    </div>
                </div>

                @php
                    $features = [
                        ['icon' => '✅', 'label' => 'Free to list events', 'color' => 'text-emerald-400'],
                        ['icon' => '📊', 'label' => 'Real-time analytics', 'color' => 'text-blue-400'],
                        ['icon' => '🎟', 'label' => 'Instant ticket delivery', 'color' => 'text-purple-400'],
                        ['icon' => '📱', 'label' => 'Mobile-friendly', 'color' => 'text-pink-400'],
                        ['icon' => '🔒', 'label' => 'Secure payments', 'color' => 'text-amber-400'],
                        ['icon' => '📧', 'label' => 'Automated notifications', 'color' => 'text-indigo-300'],
                    ];
                @endphp
                <div class="grid grid-cols-2 gap-4">
                    @foreach($features as $f)
                        <div class="bg-white/10 backdrop-blur rounded-xl p-4 flex items-center gap-3">
                            <span class="text-xl {{ $f['color'] }}">{{ $f['icon'] }}</span>
                            <span class="text-white text-sm font-medium">{{ $f['label'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ============ TESTIMONIALS ============ --}}
    <section id="testimonials" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-14">
                <p class="text-indigo-600 text-sm font-semibold uppercase tracking-wider mb-2">People Love Us</p>
                <h2 class="text-4xl font-light text-slate-800">What They're <span class="font-semibold">Saying</span>
                </h2>
            </div>

            @php
                $testimonials = [
                    ['name' => 'Alice Chen', 'role' => 'Attendee', 'initial' => 'A', 'quote' => 'Booking tickets was so easy! Got my PDF instantly and the event was fantastic.'],
                    ['name' => 'Sarah Events Co.', 'role' => 'Organiser', 'initial' => 'S', 'quote' => 'EventPortal made managing our festival so much easier. Sold out in 3 days!'],
                    ['name' => 'Bob Patel', 'role' => 'Attendee', 'initial' => 'B', 'quote' => 'Love the interface — found exactly the events I was looking for. Will use again!'],
                ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($testimonials as $t)
                    <div class="bg-slate-50 rounded-2xl border border-slate-200 p-6 card-hover">
                        <div class="flex items-center gap-3 mb-4">
                            <div
                                class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-semibold text-sm flex-shrink-0">
                                {{ $t['initial'] }}
                            </div>
                            <div>
                                <p class="font-semibold text-slate-800 text-sm">{{ $t['name'] }}</p>
                                <p class="text-slate-400 text-xs">{{ $t['role'] }}</p>
                            </div>
                        </div>
                        <div class="text-sm mb-3">⭐⭐⭐⭐⭐</div>
                        <p class="text-slate-600 text-sm leading-relaxed italic">"{{ $t['quote'] }}"</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============ CTA SECTION ============ --}}
    <section class="py-20 bg-slate-50">
        <div class="max-w-3xl mx-auto px-6 text-center">
            <div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-3xl p-12 shadow-2xl">
                <h2 class="text-4xl font-light text-white mb-4">
                    Ready to <span class="font-bold">Get Started?</span>
                </h2>
                <p class="text-indigo-200 text-base mb-8 leading-relaxed">
                    Join thousands of event-goers and organisers on Tasmania's most trusted event platform.
                </p>
                @guest
                    <div class="flex flex-wrap items-center justify-center gap-4">
                        <a href="{{ route('register') }}"
                            class="bg-white text-indigo-700 font-semibold px-8 py-3.5 rounded-xl hover:bg-indigo-50 transition-colors text-base">
                            Create Free Account →
                        </a>
                        <a href="{{ route('login') }}"
                            class="border border-white/30 text-white font-medium px-8 py-3.5 rounded-xl hover:bg-white/10 transition-colors text-base">
                            Sign In
                        </a>
                    </div>
                @else
                <a href="{{ route('events.index') }}"
                    class="inline-block bg-white text-indigo-700 font-semibold px-8 py-3.5 rounded-xl hover:bg-indigo-50 transition-colors text-base">
                    Browse Events →
                </a>
                @endauth
            </div>
        </div>
    </section>

    {{-- ============ FOOTER ============ --}}
    <footer class="bg-slate-900 text-slate-400 py-12">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-10">
                <div class="col-span-2">
                    <div class="flex items-center gap-2.5 mb-4">
                        <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z" />
                            </svg>
                        </div>
                        <span class="text-white font-semibold">EventPortal</span>
                    </div>
                    <p class="text-sm leading-relaxed max-w-xs">
                        Tasmania's premier event ticketing platform. Discover, book, and manage events with ease.
                    </p>
                </div>
                <div>
                    <p class="text-white font-semibold text-sm mb-4">Platform</p>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('events.index') }}" class="hover:text-white transition-colors">Browse
                                Events</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-white transition-colors">Create
                                Account</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-white transition-colors">Sign In</a></li>
                    </ul>
                </div>
                <div>
                    <p class="text-white font-semibold text-sm mb-4">Contact</p>
                    <ul class="space-y-2 text-sm">
                        <li>📧 hello@eventportal.com</li>
                        <li>📍 Hobart, Tasmania</li>
                        <li>🕐 Mon–Fri 9am–5pm</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-slate-800 pt-6 flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-xs">© {{ date('Y') }} EventPortal. All rights reserved.</p>
                <p class="text-xs">Built with ❤️ in Tasmania</p>
            </div>
        </div>
    </footer>

</body>

</html>