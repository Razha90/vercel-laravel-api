<?php

namespace App\Http\Middleware;

use App\Models\Account;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthen
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|string|max:69|min:69'
        ],
        [
            'token.required' => 'Maaf Data ini tidak bisa diakses',
            'token.string'=> 'Masukkan token hanya boleh berupa String',
            'token.max'=> 'Ini Bukanlah Token',
            'token.min' => 'Ini Bukanlah Token',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $token = $request->token;
        $ipClient = $request->getClientIp();
        
        $user = Account::where("remember_token", $token)->first();

        if ($user->ip != $ipClient) {
            Log::channel('acess')->warning("User Client = " . $user->email . ", IP Client = " . $ipClient . ", Endpoint = " . $request->fullUrl());
            return response()->json(["errors"=> "Server tidak dapat memastikan bahwa ini anda!"], 400);
        }

        if ($user->remember_token == $token) {
            
            Log::channel('acess')->info("User Client = " . $user->email . ", IP Client = " . $ipClient . ", Endpoint = " . $request->fullUrl());
            return $next($request);
        }
    
        return response()->json(["Ada masalah terhadap server!"]);
    }
}
