<?php

use App\Models\User;

/**
 * Returns the currently authenticated user.
 *
 * @throws Exception
 */
function user(): User
{
    $user = auth()->user();

    if ($user === null) {
        throw new Exception('The user is not authenticated.');
    }

    if (! $user instanceof User) {
        throw new Exception('The user is not an instance of '.User::class);
    }

    return $user;
}
