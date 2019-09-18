<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidateMailgun
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$this->hasRequiredFields($request)) {
            abort(403, 'Missing important headers');
        }

        if (!$this->validateMailgunToken($request)) {
            abort(403, 'Mailgun token does not match signing key');
        }

        return $next($request);
    }

    /**
     * Validate that the mailgun signature matches the timestamp/token/key hash
     *
     * @param $request
     * @return bool
     */
    public function validateMailgunToken($request)
    {
        $timestamp = $request->input('timestamp');
        $token = $request->input('token');
        $key = config('mail.webhook.signing_key');

        $hash = hash_hmac("sha256", $timestamp . $token, $key, false);

        return $hash === $request->input('signature');
    }

    /**
     * Validate that the incoming request has the appropriate mailgun headers
     *
     * @param $request
     * @return bool
     */
    public function hasRequiredFields($request)
    {
        return $request->filled(['token','timestamp', 'signature']);
    }
}
