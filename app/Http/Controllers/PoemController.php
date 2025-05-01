<?php

namespace App\Http\Controllers;

use App\Http\Requests\PoemRequest;
use App\Models\Label;
use App\Models\Poem;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class PoemController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = Poem::where('user_id', auth()->id());

        if ($request->filled('created_from')) {
            $query->whereDate('created_at', '>=', $request->created_from);
        }

        if ($request->filled('created_to')) {
            $query->whereDate('created_at', '<=', $request->created_to);
        }

        if ($request->filled('updated_from')) {
            $query->whereDate('updated_at', '>=', $request->updated_from);
        }

        if ($request->filled('visibility')) {
            $query->where('is_public', $request->visibility);
        }
        $allLabels = Label::all();

        if ($request->filled('label')) {
            $query->whereHas('labels', function ($q) use ($request) {
                $q->where('label_id', $request->label);
            });
        }

        $poems = $query->latest()->get();

        return view('poems.index', compact('poems','allLabels'));
    }


    public function search(Request $request)
    {
        $query = $request->input('q');
        $labelId = $request->input('label');

        $poems = Poem::query()
            ->when($query, fn($q) =>
            $q->where('title', 'like', "%{$query}%")
                ->orWhere('body', 'like', "%{$query}%")
            )
            ->when($labelId, fn($q) =>
            $q->whereHas('labels', fn($q2) => $q2->where('label_id', $labelId))
            )
            ->latest()
            ->paginate(10);

        $allLabels = Label::orderBy('name')->get();

        return view('poems.search', compact('poems', 'query', 'labelId', 'allLabels'));
    }


    public function create()
    {
        $allLabels = Label::all();
        $poem = new Poem();
        return view('poems.form',compact('poem', 'allLabels'));
    }

    public function edit(Poem $poem)
    {
        $allLabels = Label::all();
        $this->authorize('update', $poem);
        return view('poems.form', compact('poem', 'allLabels'));
    }
    public function store(PoemRequest $request)
    {
        $tagified = $request->input('labels'); // this is the Tagify JSON string

        $labelNames = collect(json_decode($tagified, true))
            ->pluck('value') // only keep values like "Nature"
            ->map(fn($name) => trim($name))
            ->filter()
            ->unique();

        $labelIds = $labelNames->map(function ($name) {
            return Label::firstOrCreate(['name' => $name])->id;
        });


        $this->authorize('create', Poem::class);
        $data = $request->validated();
        $poem = auth()->user()->poems()->create($data);

        $poem->labels()->sync($labelIds);

        return redirect()->route('poems.edit', $poem)->with('success', 'Poem created successfully.');
    }

    public function show(Poem $poem)
    {
        if (! $poem->is_public && auth()->id() !== $poem->user_id) {
            abort(403);
        }

        return view('poems.show', compact('poem'));
    }


    public function update(PoemRequest $request, Poem $poem)
    {
        $tagified = $request->input('labels'); // this is the Tagify JSON string

        $labelNames = collect(json_decode($tagified, true))
            ->pluck('value') // only keep values like "Nature"
            ->map(fn($name) => trim($name))
            ->filter()
            ->unique();

        $labelIds = $labelNames->map(function ($name) {
            return Label::firstOrCreate(['name' => $name])->id;
        });

        $this->authorize('update', $poem);

        $poem->update($request->validated());

        $poem->labels()->sync($labelIds);

        return redirect()->route('poems.edit', $poem)->with('success', 'Poem updated successfully.');
    }

    public function destroy(Poem $poem)
    {
        $this->authorize('delete', $poem);
        $poem->delete();

        return redirect()->route('poems.index')->with('success', 'Poem deleted.');
    }
}
