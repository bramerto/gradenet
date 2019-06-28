<?php
namespace App\Http\Middleware;
use Closure;
class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param $roles
     * @return mixed
     */
    public function handle($request, Closure $next, $roles)
    {
        if (auth()->user()) {
            $roles = explode('|', $roles);

            foreach ($roles as $role) {
                if (auth()->user()->isRole($role)) {
                    return $next($request);
                }
            }
        }
        return redirect()->back();
    }
}