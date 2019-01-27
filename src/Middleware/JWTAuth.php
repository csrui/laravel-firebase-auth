<?php

namespace csrui\LaravelFirebaseAuth\Middleware;

use Closure;
use Firebase\Auth\Token\Verifier;

class JWTAuth
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
        if(!$request->hasHeader('Authorization')) {
            return response()->json('Authorization Header not found', 401);
        }

        $token = $request->bearerToken();

        if($request->header('Authorization') == null || $token == null) {
            return response()->json('No token provided', 401);
        }

        $validation = $this->retrieveAndValidateToken($token);

        if ($validation !== true) 
        {
            return $validation;
        }

        return $next($request);
    }

    public function retrieveAndValidateToken($token)
    {

        // TODO: Check the sintax on the config retreival
        $project_id = config('firebase.project_id');

        if (empty($project_id)) 
        {
            throw new \Exception('Missing FIREBASE_PROJECT_ID', 1);
        }

        $verifier = new Verifier($project_id);

        try {
            $verifiedIdToken = $verifier->verifyIdToken($token);
            return true;
        } catch (\Firebase\Auth\Token\Exception\UnknownKey $e) {
            return response()->json($e->getMessage(), 401);
        } catch (\Firebase\Auth\Token\Exception\ExpiredToken $e) {
            return response()->json($e->getMessage(), 401);
        } catch (\Firebase\Auth\Token\Exception\IssuedInTheFuture $e) {
            return response()->json($e->getMessage(), 401);
        } catch (\Firebase\Auth\Token\Exception\InvalidToken $e) {
            return response()->json($e->getMessage(), 401);
        }
    }
}
