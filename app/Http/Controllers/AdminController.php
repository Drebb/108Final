<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AdminController extends Controller
{

    public function dashboard()
    {
        $statistics = DB::select('SELECT * FROM blog_statistics')[0];

        return Inertia::render('Admin/Dashboard', ['statistics' => $statistics]);
    }

    public function refreshStatistics()
    {
        DB::select('SELECT refresh_blog_statistics()');
        return redirect()->back()->with('message', 'Statistics refreshed successfully');
    }

    public function userFunctions()
    {
        return Inertia::render('Admin/UserFunctions');
    }

    public function getUserBlogCount(Request $request)
    {
        $count = DB::select('SELECT get_user_blog_count(?) as count', [$request->user_email])[0]->count;
        return response()->json(['count' => $count]);
    }

    public function getRecentUserBlogs(Request $request)
    {
        $blogs = DB::select('SELECT * FROM get_recent_user_blogs(?, ?)', [$request->user_email, $request->limit]);
        return response()->json(['blogs' => $blogs]);
    }

    public function users()
    {
        $users = User::with('role')->get();
        $roles = DB::table('roles')->get();
        return Inertia::render('Admin/Users', ['users' => $users, 'roles' => $roles]);
    }

    public function updateUser(Request $request, User $user)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role_id' => 'required|exists:roles,role_id',
        ]);

        // Update the user record in the database using DB facade
        DB::table('users')
            ->where('user_id', $user->user_id)  // Assuming user_id is the primary key
            ->update([
                'name' => $validated['name'],
                'role_id' => $validated['role_id'],
            ]);

        return redirect()->back()->with('message', 'User updated successfully');
    }

    public function deleteUser(User $user)
    {
        DB::table('users')->where('user_id', $user->user_id)->delete();
        return redirect()->back()->with('message', 'User deleted successfully');
    }
}
