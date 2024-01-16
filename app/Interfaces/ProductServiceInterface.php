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
    public function getProducts(): array;

    /**
     * @throws NotFoundException
     * @throws InvalidArgumentException
     */
    public function getProductById(string $id): Product;

    public function productToResponse(Product $product): ProductResource;

    public function store(ProductStoreRequest $request): Product;

    /**
     * @throws NotFoundException
     * @throws InvalidArgumentException
     */
    public function update(ProductUpdateRequest $request, string $id): Product;

    /**
     * @throws NotFoundException
     * @throws InvalidArgumentException
     */
    public function delete(string $id): bool;
}
