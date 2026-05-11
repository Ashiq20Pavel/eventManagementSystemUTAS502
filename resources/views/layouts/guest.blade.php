<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EventPortal')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@500&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'DM Sans', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-slate-950 flex">
    <div
        class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-indigo-900 via-slate-900 to-slate-950 flex-col justify-between p-14">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-indigo-600 flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z" />
                </svg>
            </div>
            <span class="text-white font-semibold text-lg">EventPortal</span>
        </div>
        <div>
            <h2 class="text-white text-5xl font-light leading-tight mb-5">Discover &amp;<br>manage events.</h2>
            <p class="text-indigo-300 text-base leading-relaxed max-w-xs">Purchase tickets, manage your events, and
                track everything in one place.</p>
        </div>
        <p class="text-slate-600 text-sm">© {{ date('Y') }} EventPortal</p>
    </div>
    <div class="flex-1 flex items-center justify-center p-8 bg-white">
        <div class="w-full max-w-md">{{ $slot }}</div>
    </div>
</body>

</html>