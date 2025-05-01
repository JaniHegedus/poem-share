@extends('layouts.app')

@section('title', 'Search Poems')

@section('content')
    <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <form method="GET" action="{{ route('search') }}" class="mb-8">
            <input type="text" name="q" value="{{ $query }}" placeholder="Search poems..."
                   class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-gray-900 dark:text-white">
        </form>
        @if($allLabels->count())
            <div class="flex flex-wrap gap-2 mb-8">
                @foreach ($allLabels as $label)
                    <a href="{{ route('search', array_filter([
                'q' => request('q'),
                'label' => $label->id,
            ])) }}"
                       class="px-3 py-1 rounded-full text-sm font-medium border
                      {{ request('label') == $label->id ? 'bg-blue-600 text-white border-blue-600' : 'text-gray-600 dark:text-gray-300 border-gray-300 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        {{ $label->name }}
                    </a>
                @endforeach

                @if(request('label'))
                    <a href="{{ route('search', ['q' => request('q')]) }}"
                       class="text-xs ml-2 underline text-red-500">
                        Clear label filter ✕
                    </a>
                @endif
            </div>
        @endif

        @if($poems->count())
            <div class="space-y-6">
                @foreach ($poems as $poem)
                    <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">
                        <h2 class="text-xl font-semibold">
                            <a href="{{ route('poems.show', $poem) }}" class="text-blue-600 hover:underline">
                                {{ $poem->title }}
                            </a>
                        </h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $poem->user->name }} • {{ $poem->created_at->format('Y.m.d') }}
                        </p>
                        <p class="mt-2 text-gray-800 dark:text-gray-200 line-clamp-3">
                            {{ Str::limit(strip_tags(html_entity_decode($poem->body)), 200) }}
                        </p>

                        {{-- Label tags --}}
                        @if ($poem->labels->isNotEmpty())
                            <div class="flex flex-wrap gap-2 mt-2">
                                @foreach ($poem->labels as $label)
                                    <span class="text-xs border border-gray-400 dark:border-gray-600 text-gray-700 dark:text-gray-300 px-2 py-0.5 rounded-full">
                                            {{ $label->name }}
                                        </span>
                                @endforeach
                            </div>
                        @endif
                        <div class="mt-4">
                            <a href="{{ route('poems.show', $poem) }}"
                               class="inline-block px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition">
                                {{ __('Read') }}
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $poems->withQueryString()->links() }}
            </div>
        @else
            <p class="text-gray-500 dark:text-gray-400">No poems found.</p>
        @endif
    </section>
@endsection
