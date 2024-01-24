<?php
namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Interfaces\UserServiceInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid as UuidValidator;

class UserService implements UserServiceInterface
{

    public function getUsers(): array
    {
        $users = User::all();

        return UserResource::collection($users)->resolve();
    }

    public function getUserById(string $id): User
    {
        if (!UuidValidator::isValid($id)) throw new \InvalidArgumentException('Invalid ID format. Should be UUID.', 400);

        $user = User::where('id', $id);

        if (!$user->exists()) throw new NotFoundException('User was not found.', 404);

        return $user->get()->first();

    }

    public function getUserByEmail(string $email): User
    {
        $user = User::where('email', $email);

        if (!$user->exists()) throw new NotFoundException('User was not found.', 404);

        return $user->get()->first();
    }

    public function userToResponse(User $user): UserResource
    {
        return new UserResource($user);
    }

    public function store($payload): User
    {
        $payload = [
            'name' => $payload['name'],
            'email' => $payload['email'],
            'password_hash' => Hash::make($payload['password']),
        ];

        return User::create($payload);
    }

    public function update(UserUpdateRequest $payload, string $id): User
    {
        $user = $this->getUserById($id);

        $payload = [
            'name' => $payload['name'],
            'email' => $payload['email'],
            'password_hash' => Hash::make($payload['password']),
        ];

        $user->update($payload);

        return $user;
    }

    public function delete(string $id): void
    {
        $user = $this->getUserById($id);

        $user->delete();
    }
}
