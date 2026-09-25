@extends('layouts.app')

@section('content')
@php
    $hour = now()->hour;
    $greeting = match (true) {
        $hour < 5 => 'Good night',
        $hour < 12 => 'Good morning',
        $hour < 18 => 'Good afternoon',
        $hour < 21 => 'Good evening',
        default => 'Good night',
    };
    $userName = auth()->user()?->name ?? 'Inocencio';
@endphp
<div class="mb-12 max-w-3xl">
    <p class="mb-4 text-xs font-bold uppercase tracking-[0.2em] text-ink/70">{{ now()->format('l, F j, Y') }}</p>
    <h1 class="display text-4xl font-bold leading-[1.05] tracking-tight sm:text-6xl">{{ $greeting }}, {{ $userName }}<span class="text-coral">.</span></h1>
    <p class="mt-5 max-w-xl text-base leading-7 text-ink/70">A focused list for the work in front of you. Keep it clear, keep it moving.</p>
</div>

<dl class="mb-12 grid border-y border-ink/20 sm:grid-cols-3">
    <div class="flex items-baseline justify-between gap-4 border-b border-ink/20 py-4 sm:border-b-0 sm:border-r sm:pr-5"><dt class="text-sm font-medium text-ink/70">All tasks</dt><dd class="text-2xl font-bold tabular-nums">{{ $stats['total'] }}</dd></div>
    <div class="flex items-baseline justify-between gap-4 border-b border-ink/20 py-4 sm:border-b-0 sm:border-r sm:px-5"><dt class="text-sm font-medium text-ink/70">In progress</dt><dd class="text-2xl font-bold tabular-nums text-coral">{{ $stats['pending'] }}</dd></div>
    <div class="flex items-baseline justify-between gap-4 py-4 sm:pl-5"><dt class="text-sm font-medium text-ink/70">Completed</dt><dd class="text-2xl font-bold tabular-nums text-emerald-900">{{ $stats['completed'] }}</dd></div>
</dl>

<div class="mb-5 flex flex-col gap-4 border-b border-ink/20 pb-4 sm:flex-row sm:items-end sm:justify-between">
    <h2 class="display text-3xl font-bold">Your tasks</h2>
    <nav aria-label="Filter tasks" class="flex gap-5 text-sm font-bold">
        @foreach (['all' => 'All', 'Pending' => 'Pending', 'Completed' => 'Completed'] as $key => $label)
            <a href="{{ route('tasks.index', $key === 'all' ? [] : ['status' => $key]) }}" @if ($filter === $key) aria-current="page" @endif class="border-b-2 pb-2 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-coral {{ $filter === $key ? 'border-coral text-ink' : 'border-transparent text-ink/70 hover:border-ink/40 hover:text-ink' }}">{{ $label }}</a>
        @endforeach
    </nav>
</div>

@if ($tasks->isEmpty())
    <div class="border-y border-dashed border-ink/30 px-6 py-12 sm:py-16">
        <p class="text-sm font-semibold text-ink/70">Nothing here yet</p>
        <h3 class="display mt-3 text-3xl font-bold">A clear desk is a clear mind.</h3>
        <p class="mt-3 max-w-md text-sm leading-6 text-ink/70">{{ $filter === 'all' ? 'Add your first task to get moving.' : 'No tasks match this filter.' }}</p>
    </div>
@else
    <div class="border-t border-ink/20">
        @foreach ($tasks as $task)
            @php
                $isOverdue = $task->status !== 'Completed' && $task->due_date && $task->due_date->isBefore(now()->startOfDay());
                $isToday = $task->status !== 'Completed' && $task->due_date && $task->due_date->isToday();
                $elapsedMinutes = $task->completed_at && $task->created_at
                    ? intdiv((int) $task->created_at->diffInSeconds($task->completed_at, true), 60)
                    : null;
                $elapsedLabel = $elapsedMinutes === null
                    ? null
                    : ($elapsedMinutes < 1
                        ? 'under 1 min'
                        : ($elapsedMinutes < 60
                            ? $elapsedMinutes . ' min'
                            : (intdiv($elapsedMinutes, 60) < 24
                                ? intdiv($elapsedMinutes, 60) . 'h ' . ($elapsedMinutes % 60) . 'm'
                                : intdiv($elapsedMinutes, 1440) . 'd ' . intdiv($elapsedMinutes % 1440, 60) . 'h')));
            @endphp
            <article class="group grid gap-4 border-b border-ink/15 px-2 py-5 transition-colors hover:bg-white/60 sm:grid-cols-[auto_1fr_auto] sm:items-center sm:px-4">
                <form method="POST" action="{{ route('tasks.status', $task) }}" class="shrink-0">@csrf @method('PATCH')<button type="submit" aria-label="{{ $task->status === 'Completed' ? 'Mark ' . $task->task_name . ' as pending' : 'Complete ' . $task->task_name }}" aria-pressed="{{ $task->status === 'Completed' ? 'true' : 'false' }}" class="flex h-11 w-11 items-center justify-center border-2 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-coral {{ $task->status === 'Completed' ? 'border-emerald-900 bg-emerald-900 text-white' : 'border-ink/40 text-transparent hover:border-coral' }}"><span aria-hidden="true" class="{{ $task->status === 'Completed' ? 'h-2 w-1 rotate-45 border-b-2 border-r-2 border-white' : '' }}"></span></button></form>
                <div class="min-w-0">
                    <h3 class="break-words text-lg font-bold {{ $task->status === 'Completed' ? 'text-ink/70 line-through' : '' }}">{{ $task->task_name }}</h3>
                    <p class="mt-1 line-clamp-2 text-sm text-ink/70">{{ $task->description ?: 'No description added.' }}</p>
                    <p class="mt-2 flex flex-wrap gap-x-3 gap-y-1 text-xs text-ink/70">
                        <span>Added {{ $task->created_at->format('M j, g:i A') }}</span>
                        @if ($task->status === 'Completed')
                            @if ($task->completed_at)
                                <span>Finished {{ $task->completed_at->format('M j, g:i A') }}</span>
                            @else
                                <span>Finish time not recorded</span>
                            @endif
                            @if ($elapsedLabel)
                                <span>Time to finish {{ $elapsedLabel }}</span>
                            @endif
                        @endif
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-sm sm:justify-end">
                    @if ($task->due_date)<span class="font-semibold {{ $isOverdue ? 'text-coral' : ($isToday ? 'text-ink' : 'text-ink/70') }}">{{ $isOverdue ? 'Overdue: ' : ($isToday ? 'Today: ' : '') }}{{ $task->due_date->format('M j') }}</span>@endif
                    <span class="rounded px-2 py-1 text-xs font-bold uppercase tracking-[0.08em] {{ $task->status === 'Completed' ? 'bg-emerald-100 text-emerald-900' : 'bg-amber-100 text-amber-950' }}">{{ $task->status }}</span>
                    <a href="{{ route('tasks.edit', $task) }}" class="inline-flex min-h-11 items-center font-semibold text-ink/75 underline decoration-ink/30 underline-offset-4 hover:text-coral focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-coral">Edit</a>
                    <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Delete this task?')">@csrf @method('DELETE')<button type="submit" class="min-h-11 font-semibold text-ink/75 underline decoration-ink/30 underline-offset-4 hover:text-coral focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-coral">Delete</button></form>
                </div>
            </article>
        @endforeach
    </div>
@endif
@endsection
