<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Str;

class PostObserver
{
    public function creating(Post $post)
    {
        $post->slug = Str::slug($post->title);
    }

    public function updating(Post $post)
    {
        $post->slug = Str::slug($post->title);
    }
}
