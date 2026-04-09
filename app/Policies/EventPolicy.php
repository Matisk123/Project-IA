<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;

class EventPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine if the user can view the model.
     */
    public function view(User $user, Event $event): bool
    {
        return true;
    }

    /**
     * Determine if the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === 'manager';
    }

    /**
     * Determine if the user can update the model.
     */
    public function update(User $user, Event $event): bool
    {
        return $user->role === 'manager';
    }

    /**
     * Determine if the user can delete the model.
     */
    public function delete(User $user, Event $event): bool
    {
        return $user->role === 'manager';
    }
}
