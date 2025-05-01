@extends('layouts.app')

@section('title', $poem->title)

@section('content')
    <section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-8">
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                {{ $poem->title }}
            </h1>

            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                {{ $poem->user->name }} • {{ $poem->created_at->format('Y.m.d') }}
            </p>

            @if ($poem->labels->isNotEmpty())
                <div class="flex flex-wrap gap-2 mb-6">
                    @foreach ($poem->labels as $label)
                        <span class="text-xs bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100 px-2 py-0.5 rounded-full font-medium">
                            {{ $label->name }}
                        </span>
                    @endforeach
                </div>
            @endif
            <div class="prose dark:prose-invert max-w-none text-gray-800 dark:text-gray-100 leading-relaxed">
                {!! $poem->body !!}
            </div>


            <div class="mt-10">
                <a href="{{ route('home') }}" class="text-blue-600 hover:underline text-sm">
                    ← {{ __('Back to Home') }}
                </a>
            </div>
        </div>
    </section>
@endsection
