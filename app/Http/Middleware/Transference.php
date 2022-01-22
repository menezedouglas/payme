<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Http;
use App\Exceptions\Transfer\TransferNoAuthorizedException;

class Transference
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = Http::get(env('URL_API_TRANSFER_VERIFY'));

        if($response->status() !== 200 || strtolower($response->json('message')) !== 'autorizado')
            throw new TransferNoAuthorizedException();

        return $next($request);
    }
}
