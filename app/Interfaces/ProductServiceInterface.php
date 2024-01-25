<?php

namespace App\Interfaces;

use App\Exceptions\NotFoundException;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Testing\Exceptions\InvalidArgumentException;

interface ProductServiceInterface
{
    /**
     * @throws NotFoundException
     * @throws InvalidArgumentException
     */
    public function getProductById(string $id): Product;
}
