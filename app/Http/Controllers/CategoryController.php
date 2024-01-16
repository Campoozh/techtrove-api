<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Interfaces\CategoryServiceInterface;
use App\Models\Category;
use App\Utility\ResponseBuilder;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    protected CategoryServiceInterface $categoryService;

    public function __construct(CategoryServiceInterface $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    function index(): JsonResponse
    {
        $categories = $this->categoryService->getCategories();

        return ResponseBuilder::sendData($categories);
    }

    function store(CategoryStoreRequest $request): JsonResponse
    {
        try {

            $category = $this->categoryService->store($request);

            $responseCategory = $this->categoryService->categoryToResponse($category)->resolve();

            return ResponseBuilder::success('Category created successfully', $responseCategory, 201);

        } catch (\Exception $error){

            return ResponseBuilder::error('An error occurred when trying to create the category.', $error->getMessage(), 500);

        }
    }

    function update(CategoryUpdateRequest $request, string $id): JsonResponse
    {
        try {

            $updatedCategory = $this->categoryService->update($request, $id);

            $responseCategory = $this->categoryService->categoryToResponse($updatedCategory)->resolve();

            return ResponseBuilder::success('Category updated successfully', $responseCategory);

        } catch (\Exception $error){

            return ResponseBuilder::error('An error occurred when attempting to update the category.', $error->getMessage(), $error->getCode());

        }
    }

    function destroy(string $id): JsonResponse
    {
        try {

            $this->categoryService->delete($id);

            return ResponseBuilder::success('Category deleted successfully');

        } catch (\Exception $error){

            return ResponseBuilder::error('An error occurred when attempting to delete the category.', $error->getMessage(), $error->getCode());

        }
    }
}
