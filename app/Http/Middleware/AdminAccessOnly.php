<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAccessOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->role_id != User::ADMIN) {
            Auth::logout();
            $request->session()->invalidate();

            return redirect()->route('login')
                            ->withInput()
                            ->withErrors(['email' => 'Only admins can access the admin panel.']);
        }

        return $next($request);
    }
}
