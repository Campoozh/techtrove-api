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

    function store(UserStoreRequest $request): JsonResponse
    {
        try {

            $user = $this->userService->store($request->validated());

            return ResponseBuilder::success('User created successfully', $user->toArray(), 201);

        }catch (\Exception $error){

            return ResponseBuilder::error('There was an error creating the user.', $error->getMessage(), 500);

        }
    }

    function show(string $id): JsonResponse
    {
        // TODO: Refactor this
        $userResponse = $this->userService->getUserById($id);

        if($userResponse instanceof User){
            try {

                $user = $this->userService->getUserById($id);

                return ResponseBuilder::sendData($user->toArray());

            } catch (\Exception $error){

                return ResponseBuilder::error('An error occurred when attempting to update the product.', $error->getMessage(), 500);

            }
        } else {

            return ResponseBuilder::error('An error occurred when attempting to retrieve the product.', $userResponse, 404);

        }
    }

    function update(UserUpdateRequest $request, string $id): JsonResponse
    {
        // TODO: Refactor this
        $userResponse = $this->userService->getUserById($id);

        if($userResponse instanceof User){

            try {

                $user = $this->userService->update($request, $id);

                return ResponseBuilder::success('User updated successfully', $user);

            } catch (\Exception $error){

                return ResponseBuilder::error('An error occurred when attempting to update the user.', $error->getMessage(), 500);

            }
        } else {

            return ResponseBuilder::error('An error occurred when attempting to update the user.', $userResponse, 404);

        }
    }

    function delete(string $id): JsonResponse
    {

        // TODO: Refactor this
        $userResponse = $this->userService->getUserById($id);

        if($userResponse instanceof User){

            try {

                $this->userService->delete($id);

                return ResponseBuilder::success('User deleted successfully');


            } catch (\Exception $error){

                return ResponseBuilder::error('An error occurred when attempting to delete the user.', $error->getMessage(), 500);

            }
        } else {

            return ResponseBuilder::error('An error occurred when attempting to delete the user.', $userResponse, 404);

        }
    }

}
