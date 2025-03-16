<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        return PostResource::collection(Post::with('user')->paginate(10));
    }

    public function store(PostRequest $request)
    {
        $post = Auth::user()->posts()->create($request->validated());
        return new PostResource($post);
    }

    public function show(Post $post)
    {
        return new PostResource($post);
    }

    public function update(PostRequest $request, Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            return response()->json(['message' => 'Siz faqat o‘z postingizni tahrirlashingiz mumkin!'], 403);
        }

        $post->update($request->validated());

        return new PostResource($post);
    }

    public function destroy(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            return response()->json(['message' => 'Siz faqat o‘z postingizni o‘chirishingiz mumkin!'], 403);
        }

        $post->delete();

        return response()->json(['message' => 'Post muvaffaqiyatli o‘chirildi!'], 200);
    }

    public function search(Request $request)
    {
        $query = Post::query();

        if ($request->has('q')) {
            $query->where('title', 'like', '%' . $request->q . '%')
                  ->orWhere('body', 'like', '%' . $request->q . '%');
        }

        return PostResource::collection($query->paginate(10));
    }
}
