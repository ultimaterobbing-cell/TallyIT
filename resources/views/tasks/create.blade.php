@extends('layouts.app')
@section('content')
<div class="mx-auto max-w-3xl"><a href="{{ route('tasks.index') }}" class="text-sm font-semibold text-ink/55 underline decoration-ink/20 underline-offset-4 hover:text-coral">← Back to tasks</a><div class="mt-10 grid gap-10 lg:grid-cols-[.7fr_1.3fr]"><div><h1 class="display mt-3 text-4xl font-bold leading-tight">Create a task<span class="text-coral">.</span></h1><p class="mt-4 text-sm leading-6 text-ink/70">Name the task, add an optional description or due date, then choose its status.</p></div><div class="border-t-2 border-ink pt-6">@include('tasks.form', ['action' => route('tasks.store'), 'method' => 'POST', 'button' => 'Create task'])</div></div></div>
@endsection
