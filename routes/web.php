<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PoemController;
use App\Http\Controllers\ProfileController;
use App\Models\Poem;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    $poems = Poem::where('user_id', auth()->id())->latest()->get();
    return view('dashboard', compact('poems'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/search', [PoemController::class, 'search'])->name('search');

Route::middleware('auth')->group(function () {
<<<<<<< Updated upstream
    Route::resource('poems', PoemController::class);
=======
    Route::get('/poems', [PoemController::class, 'index'])->name('poems.index');

// Show create form
Route::get('/poems/create', [PoemController::class, 'create'])->name('poems.create');

// Store new poem
Route::post('/poems', [PoemController::class, 'store'])->name('poems.store');

// Show a specific poem (e.g., public view)
Route::get('/poems/{poem}', [PoemController::class, 'show'])->name('poems.show');

// Show edit form
Route::get('/poems/{poem}/edit', [PoemController::class, 'edit'])->name('poems.edit');

// Update a specific poem
Route::put('/poems/{poem}', [PoemController::class, 'update'])->name('poems.update');
Route::patch('/poems/{poem}', [PoemController::class, 'update']); // optional fallback

// Delete a specific poem
Route::delete('/poems/{poem}', [PoemController::class, 'destroy'])->name('poems.destroy');
>>>>>>> Stashed changes

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__.'/auth.php';
