<?php

namespace App\Interfaces;

use App\Exceptions\NotFoundException;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Testing\Exceptions\InvalidArgumentException;

interface CategoryServiceInterface
{
    public function getCategories(): array;

    /**
     * @throws NotFoundException
     * @throws InvalidArgumentException
     */

    public function getCategoryById(string $id): Category;

    public function store(CategoryStoreRequest $request): array;

    /**
     * @throws NotFoundException
     * @throws InvalidArgumentException
     */
    public function update(CategoryUpdateRequest $request, string $id): array;

    /**
     * @throws NotFoundException
     * @throws InvalidArgumentException
     */
    public function delete(string $id): bool;
}
