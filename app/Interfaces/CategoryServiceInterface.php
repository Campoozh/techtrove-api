<?php

namespace App\Interfaces;

use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Models\Category;

interface CategoryServiceInterface
{
    public function getCategories(): array;
    public function getCategoryById(string $id): Category|string;
    public function store(CategoryStoreRequest $request): array;
    public function update(CategoryUpdateRequest $request, string $id): array;
    public function delete(string $id): bool;
}
