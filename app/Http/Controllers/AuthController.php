<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\User;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //
    public function register(Request $request)
    {
        $data = [
            "name" => $request->input('name'),
            "email" => $request->input('email'),
            "password" => Hash::make($request->input('password'))
        ];

        $create = User::create($data);

        if ($create) {
            $response = [
                "message" => 'Account has been registered!',
                "results" => [
                    "name" => $request->input('name'),
                    "email" => $request->input('email')
                ],
                "code" => 200
            ];
        } else {
            $response = [
                "message" => 'Failed to Register Account!',
                "results" => [
                    "name" => $request->input('name'),
                    "email" => $request->input('email')
                ],
                "code" => 404
            ];
        }

        return response()->json($response, $response['code']);
    }

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $email)->first();

        if ($user) {
            if (Hash::check($password, $user->password)) {
                $api_token = base64_encode(Str::random(16));

                $user->update(['api_token' => $api_token]);

                $response = [
                    "message" => 'Login Success!',
                    "api_token" => $api_token,
                    "code" => 200
                ];
            } else {
                $response = [
                    "message" => 'Wrong Password!',
                    "code" => 404
                ];
            }
        } else {
            $response = [
                "message" => 'Email not Found!',
                "code" => 404
            ];
        }

        return response()->json($response, $response['code']);
    }
}
