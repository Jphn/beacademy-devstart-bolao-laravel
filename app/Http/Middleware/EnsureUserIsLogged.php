<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsLogged
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('login'))
            return redirect()->route('admin.login');

        $diff = session('login')['timestamp']->diff(new \DateTime('America/Sao_Paulo'));

        if ($diff->d >= 1)
            return redirect()->route('admin.logout');

        return $next($request);
    }
}
