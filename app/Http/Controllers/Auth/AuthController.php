<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthSignInRequest;
use App\Http\Requests\Auth\AuthSignUpRequest;
use App\Interfaces\UserServiceInterface;
use App\Utility\ResponseBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    protected UserServiceInterface $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    function signUp(AuthSignUpRequest $request): JsonResponse
    {
        try {

            $user = $this->userService->store($request->validated());

            $token = $user->createToken('token')->plainTextToken;

            $responseUser = $this->userService->userToResponse($user);

            return ResponseBuilder::success('User created successfully', ['token'=> $token, 'user'=> $responseUser], 201);

        }catch (\Exception $error){

            return ResponseBuilder::error('There was an error creating the user.', $error->getMessage(), 500);

        }
    }

    function signIn(AuthSignInRequest $request): JsonResponse
    {
        try {

            $user = $this->userService->getUserByEmail($request->email);

            $token = $user->createToken('token')->plainTextToken;

            $responseUser = $this->userService->userToResponse($user);

            if (!Hash::check($request->password, $user->password_hash))
                return ResponseBuilder::error('There was an error when trying to login.', 'The password is incorrect.', 401);

            return ResponseBuilder::success('User logged in successfully', ['token'=> $token, 'user'=> $responseUser]);

        } catch (\Exception $error) {

            return ResponseBuilder::error('There was an error when trying to login.', $error->getMessage(), $error->getCode());

        }
    }

    function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return ResponseBuilder::error('User logged out successfully', [], 200);
    }

}
