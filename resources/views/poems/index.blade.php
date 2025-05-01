@extends('layouts.app')
@section('title', __('Your Poems'))

@section('content')
    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-medium dark:text-white">Poem List</h3>
            <a href="{{ route('poems.create') }}"
               class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                + New Poem
            </a>
        </div>

        {{-- Filter Form --}}
        <form method="GET" action="{{ route('poems.index') }}" class="mb-6 bg-white dark:bg-gray-800 p-4 rounded shadow flex flex-wrap gap-4">
            <div>
                <label for="created_from" class="block text-sm text-gray-700 dark:text-gray-300">Created From</label>
                <input type="date" name="created_from" id="created_from" value="{{ request('created_from') }}"
                       class="mt-1 rounded border-gray-300 dark:bg-gray-800 dark:border-gray-600 dark:text-white">
            </div>

            <div>
                <label for="created_to" class="block text-sm text-gray-700 dark:text-gray-300">Created To</label>
                <input type="date" name="created_to" id="created_to" value="{{ request('created_to') }}"
                       class="mt-1 rounded border-gray-300 dark:bg-gray-800 dark:border-gray-600 dark:text-white">
            </div>

            <div>
                <label for="updated_from" class="block text-sm text-gray-700 dark:text-gray-300">Modified From</label>
                <input type="date" name="updated_from" id="updated_from" value="{{ request('updated_from') }}"
                       class="mt-1 rounded border-gray-300 dark:bg-gray-800 dark:border-gray-600 dark:text-white">
            </div>

            <div>
                <label for="visibility" class="block text-sm text-gray-700 dark:text-gray-300">Visibility</label>
                <select name="visibility" id="visibility"
                        class="mt-1 rounded border-gray-300 dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                    <option value="">All</option>
                    <option value="1" {{ request('visibility') === '1' ? 'selected' : '' }}>Public</option>
                    <option value="0" {{ request('visibility') === '0' ? 'selected' : '' }}>Private</option>
                </select>
            </div>
            <div>
                <label for="label" class="block text-sm text-gray-700 dark:text-gray-300">Label</label>
                <select name="label" id="label"
                        class="mt-1 rounded border-gray-300 dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                    <option value="">All</option>
                    @foreach($allLabels as $label)
                        <option value="{{ $label->id }}" {{ request('label') == $label->id ? 'selected' : '' }}>
                            {{ $label->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="self-end">
                <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Filter
                </button>
            </div>
        </form>

        {{-- Poem List --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">
            @forelse ($poems as $poem)
                <div class="border-b border-gray-200 dark:border-gray-700 py-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $poem->title }}</h4>
                            <p class="text-gray-600 dark:text-gray-300 text-sm mt-1">
                                {{ Str::limit(strip_tags(html_entity_decode($poem->body)), 160) }}
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
                            <p class="text-xs text-gray-400 mt-1">
                                Created: {{ $poem->created_at->format('Y.m.d H:i') }} |
                                Updated: {{ $poem->updated_at->format('Y.m.d H:i') }} —
                                <span class="{{ $poem->is_public ? 'text-green-500' : 'text-yellow-400' }}">
                                    {{ $poem->is_public ? 'Public' : 'Private' }}
                                </span>
                            </p>
                        </div>
                        <div class="flex flex-col gap-1 items-end ml-4">
                            <a href="{{ route('poems.edit', $poem) }}"
                               class="text-sm text-blue-500 hover:underline">Edit</a>
                            <form method="POST" action="{{ route('poems.destroy', $poem) }}"
                                  onsubmit="return confirm('Are you sure you want to delete this poem?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-500 hover:underline">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400 italic">No poems found.</p>
            @endforelse
        </div>
    </div>
@endsection
