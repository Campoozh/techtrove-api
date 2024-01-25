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
    /**
     * @throws NotFoundException
     * @throws InvalidArgumentException
     */
    public function getCategoryById(string $id): Category;

}
