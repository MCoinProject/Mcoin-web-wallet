<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use stdClass;
use Request;

use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;

class JwtMiddleware
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
        $response = new stdClass();

        try {
            ///Check if user token is valid
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                $response->success = false;
                $response->code = 'ERR1';
                $response->message = 'User not found.';
                return response()->json($response);
            }

        } 
        ///Throws exception message for expired token
        catch (TokenExpiredException $e) {
            $response->success = false;
            $response->code = 'ERR2';
            $response->message = 'Token expired.';
            return response()->json($response);

        } 
        ///Throws exception message for invalid token
        catch (TokenInvalidException $e) {
            $response->success = false;
            $response->code = 'ERR3';
            $response->message = 'Token is invalid.';
            return response()->json($response);

        } 
        ///Throws exception message for un-include token
        catch (JWTException $e) {
            if(!Request::is('api/login') && !Request::is('api/register')) {
                $response->success = false;
                $response->code = 'ERR4';
                $response->message = 'Token is absent.';
                return response()->json($response);
            }

        } catch (Exception $e) {
            $response->success = false;
            $response->message = $e->getMessage();
            return response()->json($response);
        }

        return $next($request);
    }
}
