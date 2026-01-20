<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category');

        $posts = Post::published()
            ->when($category, function ($q) use ($category) {
                $q->where('category', $category);
            })
            ->paginate(9);

        return view('news.index', compact('posts'));
    }

    public function show(Post $post)
    {
        // Pastikan post berstatus published jika diakses via direct link
        if ($post->status !== 'published') {
            abort(404);
        }

        return view('news.show', compact('post'));
    }
}
