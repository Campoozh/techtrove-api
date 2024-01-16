<?php

namespace App\Interfaces;

use App\Exceptions\NotFoundException;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Http\Resources\CategoryResource;
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

    public function categoryToResponse(Category $category): CategoryResource;

    public function store(CategoryStoreRequest $request): Category;

    /**
     * @throws NotFoundException
     * @throws InvalidArgumentException
     */
    public function update(CategoryUpdateRequest $request, string $id): Category;

    /**
     * @throws NotFoundException
     * @throws InvalidArgumentException
     */
    public function delete(string $id): bool;
}
