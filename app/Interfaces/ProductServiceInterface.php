<?php

namespace App\Interfaces;

use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Models\Product;

interface ProductServiceInterface
{
    public function getProducts(): array;
    public function getProductById(string $id): Product|string;
    public function store(ProductStoreRequest $payload): Product;
    public function update(ProductUpdateRequest $request, string $id): array;
    public function delete(string $id): bool;
}
