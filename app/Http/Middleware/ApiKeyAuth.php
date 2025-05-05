<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiKeyAuth
{
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('X-API-KEY') ?? $request->query('api_key');
        $validApiKey = env('X_API_KEY');
        if (empty($validApiKey)) {
            return response()->json(['error' => 'Server misconfiguration: API key is missing'], 500);
        }
        if (empty($apiKey)) {
            return response()->json(['error' => 'API key is required'], 400);
        }
        
        if ($apiKey !== $validApiKey) {
            return response()->json(['error' => 'API key does not match'], 401);
        }

        return $next($request);
    }
}
