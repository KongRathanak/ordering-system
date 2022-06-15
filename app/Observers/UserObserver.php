<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function creating(User $user)
    {
        $user->name = $user->first_name . $user->last_name;
    }
}
