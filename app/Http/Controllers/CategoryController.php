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

            ResponseBuilder::success('Category created successfully', $category);

        } catch (\Exception $error){

            return ResponseBuilder::error('An error occurred when trying to create the category.', $error->getMessage(), 500);

        }

        return response()->json($category, 201);
    }

    function update(CategoryUpdateRequest $request, string $id): JsonResponse
    {

        // TODO: Refactor this
        $categoryResponse = $this->categoryService->getCategoryById($id);

        if($categoryResponse instanceof Category){

            try {

                $this->categoryService->update($request, $id);

                return ResponseBuilder::success('Category updated successfully');

            } catch (\Exception $error){

                return ResponseBuilder::error('An error occurred when attempting to update the category.', $error->getMessage(), 500);

            }
        } else {

            return ResponseBuilder::error('An error occurred when attempting to update the category.', $categoryResponse, 404);

        }

    }

    function delete(string $id): JsonResponse
    {

        // TODO: Refactor this
        $categoryResponse = $this->categoryService->getCategoryById($id);

        if($categoryResponse instanceof Category){

            try {

                $this->categoryService->delete($id);

                return ResponseBuilder::success('Category deleted successfully');

            } catch (\Exception $error){

                return ResponseBuilder::error('An error occurred when attempting to delete the category.', $error->getMessage(), 500);

            }
        } else {

            return ResponseBuilder::error('An error occurred when attempting to delete the category.', $categoryResponse, 404);

        }
    }
}
