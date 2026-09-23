@extends('layouts.app')
@section('content')
<div class="mx-auto max-w-2xl"><a href="{{ route('tasks.index') }}" class="text-sm font-semibold text-ink/50 hover:text-coral">← Back to tasks</a><h1 class="display mt-8 text-4xl font-bold">Refine the task<span class="text-coral">.</span></h1><p class="mt-3 text-ink/55">Small edits keep the plan honest.</p><div class="mt-8 rounded-3xl bg-white p-6 soft-shadow sm:p-8">@include('tasks.form', ['action' => route('tasks.update', $task), 'method' => 'PUT', 'button' => 'Save changes'])</div></div>
@endsection
