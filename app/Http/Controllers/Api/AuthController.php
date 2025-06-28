<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignUpRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponseTrait;
    public function SignUp(SignUpRequest $request)
    {
        $validated = $request->validated();
        $user = User::create($validated);
        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->successResponse("SignedUp Successfully")->header('Authorization',  $token);
    }


    public function Login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return $this->errorResponse(" incorrect credentials ");
        } else {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            return $this->successResponse("Logges in successfully")->header('Authorization',  $token);
        }
    }
    function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return $this->successResponse("loged out successfully");
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
