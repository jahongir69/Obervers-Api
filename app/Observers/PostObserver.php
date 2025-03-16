<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Str;

class PostObserver
{
    public function creating(Post $post)
    {
        $post->slug = $this->generateUniqueSlug($post->title);
    }

    public function updating(Post $post)
    {
        $post->slug = $this->generateUniqueSlug($post->title, $post->id);
    }

    private function generateUniqueSlug($title, $postId = null, $count = 0)
    {
        $slug = Str::slug($title);

        if ($count > 0) {
            $slug .= "-" . $count;
        }

        $query = Post::where('slug', $slug);
        if ($postId) {
            $query->where('id', '!=', $postId);
        }

        if ($query->exists()) {
            return $this->generateUniqueSlug($title, $postId, $count + 1);
        }

        return $slug;
    }
}
