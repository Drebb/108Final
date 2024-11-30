<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SetDBConnection
{
    public function handle(Request $request, Closure $next)
    {
        // Default connection
        $connection = config('database.default');

        $user = Auth::user();
        DB::statement("SET myapp.user_id = " . (int) $user->user_id);

        if ($user->role_id == 1) {
            DB::statement("SET myapp.currentuser = 'viewerpgaccount'");
        } elseif ($user->role_id == 2) {
            DB::statement("SET myapp.currentuser = 'editorpgaccount'");
        } elseif ($user->role_id == 3) {
            DB::statement("SET myapp.currentuser = 'adminpgaccount'");
        }

        if (Auth::check()) {
            $user = Auth::user();

            // Dynamically set connection based on role
            $connection = match ($user->role_id) {
                1 => 'pgsql_viewer',
                2 => 'pgsql_editor',
                3 => 'pgsql_admin',
                default => config('database.default'),
            };
        }

        // Purge and reconnect
        DB::purge($connection);
        config(['database.default' => $connection]);
        DB::reconnect($connection);

        DB::statement("SET myapp.user_id = " . (int) $user->user_id);
        if ($user->role_id == 1) {
            DB::statement("SET myapp.currentuser = 'viewerpgaccount'");
        } elseif ($user->role_id == 2) {
            DB::statement("SET myapp.currentuser = 'editorpgaccount'");
        } elseif ($user->role_id == 3) {
            DB::statement("SET myapp.currentuser = 'adminpgaccount'");
        }

        return $next($request);
    }
}
