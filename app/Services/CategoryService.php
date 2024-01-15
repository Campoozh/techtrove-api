<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
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

    public function getCategoryById(string $id): Category
    {
        if (!UuidValidator::isValid($id)) throw new \InvalidArgumentException('Invalid ID format. Should be UUID.', 400);

        $category = Category::where('id', $id);

        if (!$category->exists()) throw new NotFoundException('Category was not found.', 404);

        return $category->get()->first();
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

