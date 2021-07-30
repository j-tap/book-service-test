<?php

namespace App\Services\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\ControllerService as ControllerService;

use App\Models\User;

class AuthService extends ControllerService
{
    protected static $tokenType = 'auth_token';

    /**
     * register
     *
     * @param  mixed $request
     * @return void
     */
    public function registration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string']
        ]);

        if ($validator->fails())
        {
            return response($validator->errors(), 409);
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);
        $token = $user->createToken($this::$tokenType)->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response($response, 201);
    }

    /**
     * login
     *
     * @param  mixed $request
     * @return Array [ user, token ]
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails())
        {
            return response($validator->errors(), 409);
        }

        // Check email
        $user = User::where('email', $request->input('email'))->first();
        // Check password
        if (!$user || !Hash::check($request->input('password'), $user->password))
        {
            return response('The provided credentials are incorrect', 422);
        }

        $token = $user->createToken($this::$tokenType)->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return $response;
    }

    /**
     * logout
     *
     * @param  mixed $request
     * @return void
     */
    public function logout(Request $request)
    {
        if (auth('sanctum') && auth('sanctum')->user())
        {
            $user = auth('sanctum')->user();
            return $user->currentAccessToken()->delete();
        }
        return response('Unauthorized', 401);
    }

    public function clearAllTokens(Request $request)
    {
        $user = auth('sanctum')->user();
        foreach ($user->tokens as $token)
        {
            $token->delete();
        }
        return response(true);
    }
}
