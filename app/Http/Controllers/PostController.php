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
        return PostResource::collection(Post::with('user')->paginate(5));
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
        if (Auth::id() !== $post->user_id) {
            return response()->json(['message' => 'Siz faqat oz postlaringizni tahrirlashingiz mumkin'], 403);
        }
        $post->update($request->validated());
        return new PostResource($post);
    }

    public function destroy(Post $post)
    {
        if (Auth::id() !== $post->user_id) {
            return response()->json(['message' => 'Siz faqat oz postlaringizni ochirishingiz mumkin'], 403);
        }
        $post->delete();
        return response()->json(['message' => 'Post ochirildi']);
    }
    public function search(Request $request)
    {
        $query = $request->input('query');
        $posts = Post::where('title', 'like', "%$query%")->paginate(5);
        return PostResource::collection($posts);
    }
    

}
