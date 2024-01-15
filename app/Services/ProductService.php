<?php

namespace App\Services;

use App\Http\Requests\Product\ProductUpdateRequest;
use App\Interfaces\ProductServiceInterface;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid as UuidValidator;

class ProductService implements ProductServiceInterface
{
    public function getProducts(): array
    {
        return Product::all()->toArray();
    }

    public function getProductById(string $id): Product|string
    {
        if (UuidValidator::isValid($id)) {

            $product = Product::where('id', $id);

            if ($product->exists()) return $product->first();
            else return 'The product was not found.';

        } else return 'Invalid ID format.';
    }

    public function store($payload): Product
    {
        $data = $payload->only([
            'title', 'description', 'price', 'image_url', 'category_id', 'is_available'
        ]);

        return Product::create($data);
    }

    public function update(ProductUpdateRequest $request, string $id): array
    {
        $user = $this->getProductById($id);

        $payload = $request->only([
            'title', 'description', 'price', 'image_url', 'category_id', 'is_available'
        ]);

        $user->update($payload);

        return $user->toArray();
    }

    public function delete(string $id): bool
    {
        $product = $this->getProductById($id);

        return $product->delete();
    }
}
