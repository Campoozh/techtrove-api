<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Interfaces\ProductServiceInterface;
use App\Models\Product;
use Ramsey\Uuid\Uuid as UuidValidator;

class ProductService implements ProductServiceInterface
{
    public function getProducts(): array
    {
        return Product::all()->toArray();
    }

    /**
     * @throws NotFoundException
     */
    public function getProductById(string $id): Product
    {
        if (!UuidValidator::isValid($id)) throw new \InvalidArgumentException('Invalid ID format. Should be UUID.', 400);

        $product = Product::with('category')->where('id', $id);

        if(!$product->exists()) throw new NotFoundException('Product was not found.');

        return $product->get()->first();
    }

    public function productToResponse(Product $product): ProductResource
    {
        return new ProductResource($product);
    }

    public function store(ProductStoreRequest $request): Product
    {
        $data = $request->only([
            'title', 'description', 'price', 'image_url', 'category_id', 'is_available'
        ]);

        return Product::create($data);
    }

    public function update(ProductUpdateRequest $request, string $id): Product
    {
        $product = $this->getProductById($id);

        $payload = $request->only([
            'title', 'description', 'price', 'image_url', 'category_id', 'is_available'
        ]);

        $product->update($payload);

        return $product;
    }

    public function delete(string $id): bool
    {
        $product = $this->getProductById($id);

        return $product->delete();
    }
}
