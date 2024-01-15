<?php

namespace App\Http\Controllers;

use App\Utility\ResponseBuilder;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Interfaces\UserServiceInterface;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{

    protected UserServiceInterface $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    function index(): JsonResponse
    {
        $users = $this->userService->getUsers();

        return ResponseBuilder::sendData($users);
    }

    function show(string $id): JsonResponse
    {
        try {

            $user = $this->userService->getUserById($id);

            return ResponseBuilder::sendData($user->toArray());

        } catch (\Exception $error){

            return ResponseBuilder::error('An error occurred when attempting to update the product.', $error->getMessage(), $error->getCode());

        }
    }

    function update(UserUpdateRequest $request, string $id): JsonResponse
    {
        try {

            $updatedUser = $this->userService->update($request, $id);

            return ResponseBuilder::success('User updated successfully', $updatedUser);

        } catch (\Exception $error){

            return ResponseBuilder::error('An error occurred when attempting to update the user.', $error->getMessage(), $error->getCode());

        }
    }

    function destroy(string $id): JsonResponse
    {
        try {

            $this->userService->delete($id);

            return ResponseBuilder::success('User deleted successfully');

        } catch (\Exception $error){

            return ResponseBuilder::error('An error occurred when attempting to delete the user.', $error->getMessage(), $error->getCode());

        }
    }

}
