@extends('layouts.app')

@section('title', __('home.title'))

@section('content')
    {{-- Hero Section with Background Image --}}
    <section class="relative bg-cover bg-center bg-no-repeat" style="background-image: url('images/hero.jpg');">
        <div class="absolute inset-0 bg-black bg-opacity-60 dark:bg-opacity-70"></div>

        <div class="relative z-10 text-center py-24 px-4 sm:px-6 lg:px-8 border-b border-gray-300 dark:border-gray-700">
            <h1 class="text-4xl sm:text-5xl font-extrabold text-white drop-shadow">
                {{ __('home.title') }}
            </h1>
            <p class="mt-4 text-lg text-gray-200">
                {{ __('home.description') }}
            </p>
        </div>
    </section>

    {{-- Poem Grid Section --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <h2 class="text-2xl sm:text-3xl font-semibold text-center text-gray-900 dark:text-white mb-10">
            {{ __('home.recent_poems') }}
        </h2>

        @if ($poems->count())
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($poems as $poem)
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow hover:shadow-lg transition transform hover:-translate-y-1 flex flex-col h-full">
                        <div class="flex-grow">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">{{ $poem->title }}</h3>
                            <p class="text-gray-700 dark:text-gray-300 text-sm">{{ Str::limit(strip_tags(html_entity_decode($poem->body)), 160) }}</p>
                        </div>

                        <p class="text-gray-500 dark:text-gray-400 text-xs mt-4">
                            {{ $poem->user->name }} • {{ $poem->created_at->format('Y.m.d') }}
                        </p>

                        <div class="mt-4">
                            <a href="{{ route('poems.show', $poem) }}"
                               class="inline-block px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition">
                                {{ __('Read') }}
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-gray-500 dark:text-gray-400 italic mt-10">
                {{ __('home.no_poems', ['default' => 'No public poems yet.']) }}
            </p>
        @endif
    </section>
@endsection
