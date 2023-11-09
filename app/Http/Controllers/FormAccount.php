<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FormAccount extends Controller
{
    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|max:100',
            'password' => 'required|string',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $account = Account::where('email', $request->email)->first();

        if ($account && Hash::check($request->password, $account->password)) {
            $myIp = $request->getClientIp();
            $token = Str::random(69); 
            $account->remember_token = $token;
            $account->ip = $myIp;
            $account->update();
            return response()->json([
                'message'=> 'Login succes',
                'data' => [
                    'email' => $account->email,
                    'token' => $token
                ]
            ],200);
        } else {
            return response()->json(['message'=> 'invalid login'],400);
        }



        // $user = Account::find();
        // $account = $request->getClientIp();
        // $token = Str::random(69);
        // return response()->json(["message"=>$account], 200);
        // return dd($token);
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|max:100|unique:account,email',
            'password' => 'required|string',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }
        $account = $request->getClientIp();
        $token = Str::random(69);

        $getIp = $request->getClientIp();

        $account = new Account;
        $account->email = $request->email;
        $account->password = bcrypt($request->password);
        $account->ip = $getIp;
        $account->remember_token = $token;

        if (!$account->save()) {
            return response()->json(['message'=> 'Akun Gagal Dibuat'], 400);
        }
        return response()->json([
            'message'=> 'Akun Berhasil Dibuat, Silahkan Ambil Token',
            'data'=> [
                'email' => $request->email,
                'token'=> $token
            ]
    ], 200);
    }  

    public function logs() {
        $logContent = file_get_contents(storage_path('logs/acess.log'));
        return dd($logContent);
    }
}
