<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\AuthSignInRequest;
use App\Http\Requests\Auth\AuthSignUpRequest;
use App\Interfaces\UserServiceInterface;
use App\Models\User;
use App\Utility\ResponseBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    function signUp(AuthSignUpRequest $request): JsonResponse
    {
        try {

            $user = $this->userService->store($request->validated());

            $token = $user->createToken('token')->plainTextToken;

            return ResponseBuilder::success('User created successfully', ['token'=> $token, 'user'=> $user->toArray()], 201);

        }catch (\Exception $error){

            return ResponseBuilder::error('There was an error creating the user.', $error->getMessage(), 500);

        }
    }

    function signIn(AuthSignInRequest $request): JsonResponse
    {
        $userResponse = $this->userService->getUserByEmail($request->email);

        if($userResponse instanceof User){

            $checkPassword = Hash::check($request->password, $userResponse->password_hash);

            if($checkPassword){
                $token = $userResponse->createToken('token')->plainTextToken;

                return ResponseBuilder::success('User logged in successfully', ['token'=> $token, 'user'=> $userResponse->toArray()], 201);
            } else {

                return ResponseBuilder::error('The password provided is incorrect.', [], 401);

            }
        } else {

            return ResponseBuilder::error('There was an error when trying to login.', $userResponse, 500);

        }
    }

    function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return ResponseBuilder::error('User logged out successfully', [], 200);
    }

}
