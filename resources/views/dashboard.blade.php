@extends('layouts.app')
@section('title', __('Dashboard') )


@section('content')
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                {{ __("You're logged in!") }}
            </h3>

            {{-- Poem Summary --}}
            <div class="flex justify-between items-center mb-4">
                <h4 class="text-md font-medium text-gray-700 dark:text-gray-200">Your Recent Poems</h4>
                <div>
                    <a href="{{ route('poems.index') }}"
                       class="text-sm text-blue-500 hover:underline mr-4">View All</a>
                    <a href="{{ route('poems.create') }}"
                       class="px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">+ New Poem</a>
                </div>
            </div>

            @if ($poems->count())
                <ul class="divide-y divide-gray-300 dark:divide-gray-700">
                    @foreach ($poems->take(5) as $poem)
                        <li class="py-3">
                            <div class="flex justify-between">
                                <div>
                                    <h5 class="font-semibold text-gray-800 dark:text-white">{{ $poem->title }}</h5>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ Str::limit($poem->content, 80) }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <a href="{{ route('poems.edit', $poem) }}"
                                       class="text-sm text-blue-500 hover:underline">Edit</a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-sm text-gray-500 dark:text-gray-400 italic">You haven’t written any poems yet.</p>
            @endif
        </div>
    </div>
@endsection
