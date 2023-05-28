<?php

namespace Tests\Feature;

use App\Models\{Post, Language};

trait TraitAnyPost
{
    public function getAnyPost()
    {
        $post = Post::first();

        return \App\Repositories\PostRepository::beCollection($post)->toArray();
    }
}
