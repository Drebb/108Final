<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Mews\Purifier\Purifier;

class BlogController extends Controller
{

    public function index(Request $request)
    {
        $query = Blog::with(['user', 'categories']);

        if ($request->has('search')) {
            $query->where('title', 'ilike', '%' . $request->search . '%');
        }

        $blogs = $query->latest()->get();

        return Inertia::render('Blogs/Index', [
            'blogs' => $blogs,
            'user' => Auth::user(),
        ]);
    }


    public function recent()
    {
        $recentBlogs = DB::select('SELECT * FROM recent_blogs');
        return Inertia::render('Blogs/Index', [
            'blogs' => $recentBlogs,
            'user' => Auth::user(),
        ]);
    }

    public function random()
    {
        $randomBlog = DB::select('SELECT * FROM random_blog');

        return Inertia::render('Blogs/Index', [
            'blogs' => $randomBlog,
            'user' => Auth::user(),
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        return Inertia::render('Blogs/Create', [
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,category_id',
        ]);

        $title = strip_tags($request->title);
        $content = strip_tags($request->content);

        $blog = Blog::create([
            'title' => $title,
            'content' => $content,
            'user_id' => Auth::id(),
        ]);

        $blog->categories()->attach($request->category_id);

        return redirect()->route('blogs.index');
    }

    public function show(Blog $blog)
    {
        $blog->load('user', 'categories');

        return Inertia::render('Blogs/Show', ['blog' => $blog]);
    }

    public function edit(Blog $blog)
    {
        $categories = Category::all();

        $blog->load('categories');


        return Inertia::render('Blogs/Edit', [
            'blog' => $blog,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, Blog $blog)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,category_id',
        ]);

        $title = strip_tags($request->title);
        $content = strip_tags($request->content);


        DB::table('blogs')->where('blog_id', $blog->blog_id)->update([
            'title' => $title,
            'content' => $content,
        ]);


        DB::table('blog_category')->where('blog_id', $blog->blog_id)->update([
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('blogs.show', $blog);
    }



    public function destroy(Blog $blog)
    {
        DB::table('blogs')->where('blog_id', $blog->blog_id)->delete();

        return redirect()->route('blogs.index');
    }
}
