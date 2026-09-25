<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'TallyIT | Task Manager' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['DM Sans', 'ui-sans-serif', 'system-ui'] },
                    colors: { ink: '#172126', mint: '#cfe8d8', coral: '#b23a26', paper: '#f5f0e7' }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --ink: #172126; --paper: #f5f0e7; --coral: #b23a26; --mint: #cfe8d8; }
        body { font-family: 'DM Sans', sans-serif; background-color: var(--paper); color: var(--ink); }
        h1, h2, h3, .display { font-family: 'Space Grotesk', sans-serif; }
        .ledger-page { position: relative; isolation: isolate; background-image: radial-gradient(circle at 80% 12%, rgba(207, 232, 216, .55), transparent 27rem); }
        .site-mark { letter-spacing: -.08em; }
    </style>
</head>
<body class="ledger-page min-h-screen">
    <nav class="border-b border-ink/15 bg-paper/90">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-5 lg:px-10">
            <a href="{{ route('tasks.index') }}" class="flex items-center gap-3 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-coral">
                <span class="display text-xl font-bold tracking-tight">Tally<span class="text-coral">IT</span></span>
            </a>
            <div class="hidden text-xs font-bold uppercase tracking-[0.18em] text-ink/70 sm:block">Personal task manager</div>
            <a href="{{ route('tasks.create') }}" class="inline-flex min-h-11 items-center bg-coral px-4 text-sm font-bold text-white transition hover:bg-[#8e2e20] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-coral">New task <span class="ml-2" aria-hidden="true">+</span></a>
        </div>
    </nav>
    <main class="mx-auto max-w-7xl px-5 py-10 lg:px-10 lg:py-14">
        @if (session('success'))
            <div class="mb-6 rounded-2xl border border-emerald-300 bg-emerald-50 px-5 py-3 text-sm font-medium text-emerald-900">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="mb-6 rounded-2xl border border-red-300 bg-red-50 px-5 py-3 text-sm text-red-900">
                Please check the highlighted fields and try again.
            </div>
        @endif
        @yield('content')
    </main>
</body>
</html>
