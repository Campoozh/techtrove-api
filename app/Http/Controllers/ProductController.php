<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Interfaces\ProductServiceInterface;
use App\Models\Product;
use App\Utility\ResponseBuilder;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    protected ProductServiceInterface $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    function index(): JsonResponse {

        $products = $this->productService->getProducts();

        return ResponseBuilder::sendData($products);
    }

    function store(ProductStoreRequest $request): JsonResponse
    {
        try {

            $product = $this->productService->store($request);

            return ResponseBuilder::success('Product created successfully', $product->toArray(), 201);

        } catch (\Exception $error){

            return ResponseBuilder::error('An error occurred when trying to create the product.', $error->getMessage(), 500);

        }
    }

    function show(string $id): JsonResponse
    {
        try {

            $product = $this->productService->getProductById($id);

            $responseProduct = $this->productService->productToResponse($product)->resolve();

            return ResponseBuilder::sendData($responseProduct);

        } catch (\Exception $error) {

            return ResponseBuilder::error('An error occurred when attempting to update the product.', $error->getMessage(), $error->getCode());

        }
    }

    function update(ProductUpdateRequest $request, string $id): JsonResponse
    {
        try {

            $updatedProduct = $this->productService->update($request, $id);

            $responseProduct = $this->productService->productToResponse($updatedProduct)->resolve();

            return ResponseBuilder::success('Product updated successfully', $responseProduct);

        } catch (\Exception $error){

            return ResponseBuilder::error('An error occurred when attempting to update the product.', $error->getMessage(), $error->getCode());

        }
    }

    function destroy(string $id): JsonResponse
    {
        try {

            $this->productService->delete($id);

            return ResponseBuilder::success('Product deleted successfully');


        } catch (\Exception $error){

            return ResponseBuilder::error('An error occurred when attempting to delete the product.', $error->getMessage(), $error->getCode());

        }
    }
}
