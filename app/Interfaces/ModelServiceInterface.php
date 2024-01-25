<?php

namespace App\Interfaces;

use App\Exceptions\NotFoundException;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Testing\Exceptions\InvalidArgumentException;

interface ModelServiceInterface
{
    public function getAll(): array;

    public function store(FormRequest $request): Model;

    public function formatToResponse(Model $model): JsonResource;

    /**
     * @throws NotFoundException
     * @throws InvalidArgumentException
     */
    public function update(FormRequest $request, string $id): Model;

    /**
     * @throws NotFoundException
     * @throws InvalidArgumentException
     */
    public function delete(string $id): bool;

}
