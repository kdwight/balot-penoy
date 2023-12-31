<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TodosAccess
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
        abort_if(!in_array('todos', array_column(auth()->user()->role->pages ?? [], 'name')), 403);

        return $next($request);
    }
}
