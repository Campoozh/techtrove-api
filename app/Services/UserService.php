<?php
namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Interfaces\ModelServiceInterface;
use App\Interfaces\UserServiceInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid as UuidValidator;

class UserService implements UserServiceInterface, ModelServiceInterface
{

    public function getAll(): array
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

    public function formatToResponse(Model $model): JsonResource
    {
        return new UserResource($model);

    }

    public function store(FormRequest $request): User
    {

        $validatedRequest = $request->validated();

        $payload = [
            'name' => $validatedRequest['name'],
            'email' => $validatedRequest['email'],
            'password_hash' => Hash::make($validatedRequest['password']),
        ];

        return User::create($payload);
    }

    public function update(FormRequest $request, string $id): User
    {
        $user = $this->getUserById($id);

        $payload = [
            'name' => $request['name'],
            'email' => $request['email'],
            'password_hash' => Hash::make($request['password']),
        ];

        $user->update($payload);

        return $user;
    }

    public function delete(string $id): bool
    {
        $user = $this->getUserById($id);

        return $user->delete();
    }
}
