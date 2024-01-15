<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Interfaces\ProductServiceInterface;
use App\Models\Product;
use App\Models\User;
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
        // TODO: Refactor this
        $productResponse = $this->productService->getProductById($id);

        if($productResponse instanceof Product){
            try {

                $product = $this->productService->getProductById($id);

                return ResponseBuilder::sendData($product->toArray());

            } catch (\Exception $error){

                return ResponseBuilder::error('An error occurred when attempting to update the product.', $error->getMessage(), 500);

            }
        } else {

            return ResponseBuilder::error('An error occurred when attempting to retrieve the product.', $productResponse, 404);

        }
    }

    function update(ProductUpdateRequest $request, string $id): JsonResponse
    {
        // TODO: Refactor this
        $productResponse = $this->productService->getProductById($id);

        if($productResponse instanceof Product){
            try {

                $product = $this->productService->update($request, $id);

                return ResponseBuilder::success('Product updated successfully', $product);

            } catch (\Exception $error){

                return ResponseBuilder::error('An error occurred when attempting to update the product.', $error->getMessage(), 500);

            }
        } else {

            return ResponseBuilder::error('An error occurred when attempting to update the product.', $productResponse, 404);

        }
    }

    function delete(string $id): JsonResponse
    {

        // TODO: Refactor this
        $productResponse = $this->productService->getProductById($id);

        if($productResponse instanceof Product){

            try {

                $this->productService->delete($id);

                return ResponseBuilder::success('Product deleted successfully');


            } catch (\Exception $error){

                return ResponseBuilder::error('An error occurred when attempting to delete the product.', $error->getMessage(), 500);

            }
        } else {

            return ResponseBuilder::error('An error occurred when attempting to delete the product.', $productResponse, 404);

        }
    }
}
