<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Services\UserService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(RegisterRequest $request){
        try {
            $data = $request->safe()->only(['name', 'email']);
            $this->userService->create($data, $request->password);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully'
            ], 200);

        }
        catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

    }

    public function login(LoginRequest $request){
        try {
            $data = $request->safe()->only(['email', 'password']);
            if(!Auth::attempt($data)){
                return response()->json([
                    'status' => false,
                    'message' => 'Credential does not match!',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("REST URLSHORTENER")->plainTextToken
            ], 200);

        }
        catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

}
