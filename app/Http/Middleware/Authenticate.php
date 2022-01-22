<?php

namespace App\Http\Middleware;

use App\Exceptions\Auth\UnauthorizedException;
use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     * @throws UnauthorizedException
     */
    public function handle($request, Closure $next, ...$guards)
    {

        if(!$user = $request->user())
            throw new UnauthorizedException();

        if (!in_array($user->type->name, $guards)) {
            auth()->logout();
            throw new UnauthorizedException();
        }

        return $next($request);
    }
}
