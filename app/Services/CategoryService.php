<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Http\Resources\CategoryResource;
use App\Interfaces\CategoryServiceInterface;
use App\Interfaces\ModelServiceInterface;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Resources\Json\JsonResource;
use Ramsey\Uuid\Uuid as UuidValidator;

class CategoryService implements CategoryServiceInterface, ModelServiceInterface
{
    public function getAll(): array
    {
        $categories = Category::all();

        return CategoryResource::collection($categories)->resolve();
    }

    public function getCategoryById(string $id): Category
    {
        if (!UuidValidator::isValid($id)) throw new \InvalidArgumentException('Invalid ID format. Should be UUID.', 400);

        $category = Category::where('id', $id);

        if (!$category->exists()) throw new NotFoundException('Category was not found.', 404);

        return $category->get()->first();
    }

    public function formatToResponse(Model $model): JsonResource
    {
        return new CategoryResource($model);

    }

    public function store(FormRequest $request): Category
    {
        $payload = $request->only(['name']);

        return Category::create($payload);
    }

    public function update(FormRequest $request, string $id): Category
    {
        $category = $this->getCategoryById($id);

        $category->update(["name" => $request['name']]);

        return $category;
    }

    public function delete(string $id): bool
    {
        $category = $this->getCategoryById($id);

        return $category->delete();
    }
}

