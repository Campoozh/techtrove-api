<?php

namespace App\Services;

use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Interfaces\CategoryServiceInterface;
use App\Models\Category;
use Ramsey\Uuid\Uuid as UuidValidator;

class CategoryService implements CategoryServiceInterface
{
    public function getCategories(): array
    {
        return Category::all()->toArray();
    }

    public function getCategoryById(string $id): Category|string
    {
        if (UuidValidator::isValid($id)) {

            $category = Category::where('id', $id);

            if ($category->exists()) return $category->first();
            else return 'The category was not found.';

        } else return 'Invalid ID format.';
    }

    public function store(CategoryStoreRequest $request): array
    {
        $payload = $request->only(['name']);

        return Category::create($payload)->toArray();
    }

    public function update(CategoryUpdateRequest $request, string $id): array
    {
        $category = $this->getCategoryById($id);

        $category->update(["name" => $request['name']]);

        return $category->toArray();
    }

    public function delete(string $id): bool
    {
        $category = $this->getCategoryById($id);

        return $category->delete();
    }
}

