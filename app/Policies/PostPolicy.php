<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
        //verificamos que el mismos usuario que publico el post sea quien pueda eliminarlo
        return $user->id === $post->user_id;
    }

}
