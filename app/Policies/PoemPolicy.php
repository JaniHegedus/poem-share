<?php

namespace App\Policies;

use App\Models\Poem;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PoemPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true; // allow all authenticated users to view list
    }

    public function view(User $user, Poem $poem): bool
    {
        return true; // or $poem->user_id === $user->id if private poems
    }

    public function create(User $user): bool
    {
        return true; // allow all logged-in users to create poems
    }

    public function update(User $user, Poem $poem): bool
    {
        return $poem->user_id === $user->id;
    }

    public function delete(User $user, Poem $poem): bool
    {
        return $poem->user_id === $user->id;
    }

    public function restore(User $user, Poem $poem): bool
    {
        return false;
    }

    public function forceDelete(User $user, Poem $poem): bool
    {
        return false;
    }
}
