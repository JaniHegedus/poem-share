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
    Route::resource('poems', PoemController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__.'/auth.php';
