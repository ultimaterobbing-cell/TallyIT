@extends('layouts.app')

@section('content')
<div class="mb-10 flex flex-col justify-between gap-6 md:flex-row md:items-end">
    <div>
        <p class="mb-3 text-xs font-bold uppercase tracking-[0.22em] text-coral">Wednesday, {{ now()->format('F j, Y') }}</p>
        <h1 class="display text-4xl font-bold tracking-tight sm:text-5xl">Good morning, <span class="text-coral">Inocencio.</span></h1>
        <p class="mt-3 max-w-lg text-ink/60">Keep your momentum. One clear task at a time.</p>
    </div>
    <a href="{{ route('tasks.create') }}" class="inline-flex items-center justify-center rounded-xl bg-coral px-5 py-3 font-semibold text-white shadow-lg shadow-coral/20 transition hover:-translate-y-0.5">Add a task <span class="ml-3 text-xl">→</span></a>
</div>

<div class="mb-10 grid gap-4 sm:grid-cols-3">
    <div class="rounded-2xl bg-ink p-5 text-white soft-shadow"><p class="text-sm text-white/60">All tasks</p><p class="mt-4 text-4xl font-bold">{{ $stats['total'] }}</p><p class="mt-2 text-xs text-mint">Your complete list</p></div>
    <div class="rounded-2xl bg-mint p-5 soft-shadow"><p class="text-sm text-ink/60">In progress</p><p class="mt-4 text-4xl font-bold">{{ $stats['pending'] }}</p><p class="mt-2 text-xs text-ink/60">Keep the rhythm going</p></div>
    <div class="rounded-2xl bg-white p-5 soft-shadow"><p class="text-sm text-ink/60">Completed</p><p class="mt-4 text-4xl font-bold">{{ $stats['completed'] }}</p><p class="mt-2 text-xs text-coral">Nice work so far</p></div>
</div>

<div class="mb-5 flex flex-wrap items-center justify-between gap-3">
    <h2 class="display text-2xl font-bold">Your tasks</h2>
    <div class="flex rounded-xl border border-ink/10 bg-white p-1 text-sm font-medium">
        @foreach (['all' => 'All', 'Pending' => 'Pending', 'Completed' => 'Completed'] as $key => $label)
            <a href="{{ route('tasks.index', $key === 'all' ? [] : ['status' => $key]) }}" class="rounded-lg px-3 py-2 {{ $filter === $key ? 'bg-ink text-white' : 'text-ink/55 hover:text-ink' }}">{{ $label }}</a>
        @endforeach
    </div>
</div>

@if ($tasks->isEmpty())
    <div class="rounded-3xl border border-dashed border-ink/20 bg-white px-6 py-16 text-center soft-shadow"><div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-mint text-2xl">✓</div><h3 class="display text-xl font-bold">A clear desk is a clear mind.</h3><p class="mt-2 text-sm text-ink/55">{{ $filter === 'all' ? 'Add your first task to get moving.' : 'No tasks match this filter.' }}</p></div>
@else
    <div class="space-y-3">
        @foreach ($tasks as $task)
            <article class="group flex flex-col gap-4 rounded-2xl border border-ink/10 bg-white p-5 transition hover:border-coral/40 hover:shadow-lg hover:shadow-ink/5 sm:flex-row sm:items-center">
                <form method="POST" action="{{ route('tasks.status', $task) }}" class="shrink-0">@csrf @method('PATCH')<button title="Toggle status" class="flex h-9 w-9 items-center justify-center rounded-full border-2 {{ $task->status === 'Completed' ? 'border-emerald-500 bg-emerald-500 text-white' : 'border-ink/20 text-transparent hover:border-coral' }}">✓</button></form>
                <div class="min-w-0 flex-1"><h3 class="font-bold {{ $task->status === 'Completed' ? 'text-ink/40 line-through' : '' }}">{{ $task->task_name }}</h3><p class="mt-1 truncate text-sm text-ink/50">{{ $task->description ?: 'No description added.' }}</p></div>
                <div class="flex items-center gap-4 text-sm">
                    <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $task->status === 'Completed' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">{{ $task->status }}</span>
                    @if ($task->due_date)<span class="text-ink/45">{{ $task->due_date->format('M j') }}</span>@endif
                    <a href="{{ route('tasks.edit', $task) }}" class="font-semibold text-ink/50 hover:text-coral">Edit</a>
                    <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Delete this task?')">@csrf @method('DELETE')<button class="font-semibold text-ink/50 hover:text-red-600">Delete</button></form>
                </div>
            </article>
        @endforeach
    </div>
@endif
@endsection
