<?php

namespace App\Interfaces;

use App\Exceptions\NotFoundException;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Testing\Exceptions\InvalidArgumentException;

interface UserServiceInterface
{
    /**
     * @throws NotFoundException
     * @throws InvalidArgumentException
     */
    public function getUserById(string $id): User;

    /**
     * @throws NotFoundException
     * @throws InvalidArgumentException
     */
    public function getUserByEmail(string $email): User;

}
