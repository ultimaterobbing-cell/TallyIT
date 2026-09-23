<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Focus | Task Manager' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['DM Sans', 'ui-sans-serif', 'system-ui'] },
                    colors: { ink: '#172126', mint: '#d8f3e6', coral: '#ff755c', paper: '#f7f8f5' }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'DM Sans', sans-serif; background: #f7f8f5; color: #172126; }
        h1, h2, h3, .display { font-family: 'Space Grotesk', sans-serif; }
        .grain { background-image: radial-gradient(#1721260d 0.7px, transparent 0.7px); background-size: 10px 10px; }
        .soft-shadow { box-shadow: 0 18px 50px rgba(23, 33, 38, .07); }
    </style>
</head>
<body class="grain min-h-screen">
    <nav class="border-b border-ink/10 bg-paper/90 backdrop-blur">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-5 py-5 lg:px-8">
            <a href="{{ route('tasks.index') }}" class="flex items-center gap-3">
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-ink text-lg font-bold text-mint">F</span>
                <span class="display text-lg font-bold tracking-tight">Focus<span class="text-coral">.</span></span>
            </a>
            <div class="hidden text-sm text-ink/55 sm:block">Your small steps, organized.</div>
            <a href="{{ route('tasks.create') }}" class="rounded-xl bg-ink px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-coral">+ New task</a>
        </div>
    </nav>
    <main class="mx-auto max-w-6xl px-5 py-10 lg:px-8 lg:py-14">
        @if (session('success'))
            <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-3 text-sm font-medium text-emerald-800">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-3 text-sm text-red-800">
                Please check the highlighted fields and try again.
            </div>
        @endif
        @yield('content')
    </main>
</body>
</html>
