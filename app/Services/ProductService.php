<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Interfaces\ModelServiceInterface;
use App\Interfaces\ProductServiceInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Resources\Json\JsonResource;
use Ramsey\Uuid\Uuid as UuidValidator;

class ProductService implements ProductServiceInterface, ModelServiceInterface
{
    public function getAll(): array
    {
        $products = Product::with('category')->get();

        return ProductResource::collection($products)->resolve();
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

    public function formatToResponse(Model $model): JsonResource
    {
        return new ProductResource($model);
    }

    public function store(FormRequest $request): Product
    {
        $data = $request->only([
            'title', 'description', 'price', 'image_url', 'category_id', 'is_available'
        ]);

        $product = Product::create($data);

        return $product->load('category');
    }

    public function update(FormRequest $request, string $id): Product
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
