<?php

namespace App\Interfaces;

use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;

interface UserServiceInterface
{

    public function getUsers(): array;
    public function getUserById(string $id): User|string;
    public function getUserByEmail(string $email): User|string;
    public function store(array $payload): User;
    public function update(UserUpdateRequest $payload, string $id): array;
    public function delete(string $id): void;

}
