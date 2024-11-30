<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

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

        $blog = Blog::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
        ]);

        // Attach the blog to the selected category
        $blog->categories()->attach($request->category_id);

        return redirect()->route('blogs.index');
    }

    public function show(Blog $blog)
    {
        // Eager load the categories and the user
        $blog->load('user', 'categories');

        return Inertia::render('Blogs/Show', ['blog' => $blog]);
    }

    public function edit(Blog $blog)
    {
        // Retrieve all available categories
        $categories = Category::all();


        // Load the categories relationship for the blog
        $blog->load('categories');  // Ensure that the associated categories are loaded


        // Return to the edit view with the blog and categories
        return Inertia::render('Blogs/Edit', [
            'blog' => $blog,  // Pass the blog with its categories
            'categories' => $categories,  // Pass all categories for the dropdown
        ]);
    }

    public function update(Request $request, Blog $blog)
    {

        $before = DB::select("SELECT current_user, session_user");



        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,category_id', // Ensure valid category_id
        ]);


        $blog->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        // Sync the blog's category in the pivot table
        $blog->categories()->sync([$request->category_id]);

        // Your update code here
        $after = DB::select("SELECT current_user, session_user");

        //dd($before, $after);


        return redirect()->route('blogs.show', $blog);
    }



    public function destroy(Blog $blog)
    {
        $user = Auth::user();
        DB::statement('SET myapp.user_id = ' . $user->user_id);
        $blog->delete();

        return redirect()->route('blogs.index');
    }
}
