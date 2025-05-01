@extends('layouts.app')
@section('title', $poem->exists ? 'Edit Poem' : 'Create Poem' )


@section('content')
    <div class="py-8 max-w-3xl mx-auto sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-4 px-4 py-2 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif
        @error('title')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
            <form method="POST" action="{{ $poem->exists ? route('poems.update', $poem) : route('poems.store') }}">
        @csrf
            @if ($poem->exists)
                @method('PUT')
            @endif

            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                <input type="text" id="title" name="title" required
                       value="{{ old('title', $poem->title) }}"
                       class="mt-1 block w-full rounded-md dark:bg-gray-800 dark:border-gray-600 dark:text-white border-gray-300 shadow-sm">
            </div>

            <div class="mb-4">
                <label for="body" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Content</label>
                <textarea id="myeditorinstance" name="body" rows="6" required
                          class="mt-1 block w-full rounded-md dark:bg-gray-800 dark:border-gray-600 dark:text-white border-gray-300 shadow-sm">{{ old('body', $poem->body) }}</textarea>
            </div>

            <div class="mb-4 flex items-center">
                <input type="checkbox" id="is_public" name="is_public" value="1"
                       {{ old('is_public', $poem->is_public) ? 'checked' : '' }}
                       class="mr-2 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800">
                <label for="is_public" class="text-sm text-gray-700 dark:text-gray-300">Make this poem public</label>
            </div>
            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
            <div class="mb-4">
                <label for="labels" class="block text-sm text-gray-700 dark:text-gray-300">Labels (Enter to add)</label>
                <input type="text" id="labels" name="labels" value="{{ old('labels', $poem->labels->pluck('name')->implode(',')) }}"
                       class="tagify-field mt-1 block w-full rounded-md dark:bg-gray-800 dark:border-gray-600 dark:text-white border-gray-300 shadow-sm">
            </div>
            <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                {{ $poem->exists ? 'Update' : 'Create' }}
            </button>
        </form>
    </div>
    <!-- Tagify JS -->
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script>
        const input = document.querySelector('#labels');

        // existing labels from the DB to use for autocomplete
        const existingLabels = @json($allLabels->pluck('name'));

        new Tagify(input, {
            whitelist: existingLabels,
            dropdown: {
                enabled: 1, // show suggestions after 1 char
                classname: 'tags-look',
                maxItems: 10,
                closeOnSelect: false
            }
        });
    </script>
@endsection
