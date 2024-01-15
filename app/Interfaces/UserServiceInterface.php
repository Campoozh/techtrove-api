<?php

namespace App\Interfaces;

use App\Exceptions\NotFoundException;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;
use Illuminate\Testing\Exceptions\InvalidArgumentException;

interface UserServiceInterface
{

    public function getUsers(): array;

    /**
     * @throws NotFoundException
     * @throws InvalidArgumentException
     */
    public function getUserById(string $id): User|string;

    public function getUserByEmail(string $email): User|string;

    public function store(array $payload): User;

    /**
     * @throws NotFoundException
     * @throws InvalidArgumentException
     */
    public function update(UserUpdateRequest $payload, string $id): array;

    /**
     * @throws NotFoundException
     * @throws InvalidArgumentException
     */
    public function delete(string $id): void;

}
