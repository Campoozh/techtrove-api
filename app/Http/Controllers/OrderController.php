<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\OrderRequest;
use App\Interfaces\OrderServiceInterface;
use App\Utility\ResponseBuilder;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{

    private OrderServiceInterface $orderService;

    public function __construct(OrderServiceInterface $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(): JsonResponse
    {
        $orders = $this->orderService->getAll();

        return ResponseBuilder::sendData($orders);
    }

    public function show(string $id): JsonResponse
    {
        try {

            $order = $this->orderService->getOrderById($id);

            $responseOrder = $this->orderService->formatToResponse($order)->resolve();

            return ResponseBuilder::sendData($responseOrder);

        } catch (\Exception $error) {

            return ResponseBuilder::error('An error occurred when trying to retrieve the order', $error->getMessage(), 400);

        }
    }

    public function showUserOrders(string $userId): JsonResponse
    {
        try {

            $orders = $this->orderService->getUserOrders($userId);

            return ResponseBuilder::sendData($orders);

        } catch (\Exception $error) {

            return ResponseBuilder::error('An error occurred when trying to retrieve the order', $error->getMessage(), 400);

        }
    }

    public function store(OrderRequest $request): JsonResponse
    {
        try {

            $order = $this->orderService->store($request);

            $responseOrder = $this->orderService->formatToResponse($order)->resolve();

            return ResponseBuilder::success('Order created successfully',$responseOrder, 201);

        } catch (\Exception $error) {

            return ResponseBuilder::error('An error occurred when trying to store the order', $error->getMessage(), 400);

        }
    }

    public function update(OrderRequest $request, string $id): JsonResponse
    {
        try {

            $updatedOrder = $this->orderService->update($request, $id);

            $responseOrder = $this->orderService->formatToResponse($updatedOrder)->resolve();

            return ResponseBuilder::success('Order updated successfully',$responseOrder);

        } catch (\Exception $error) {

            return ResponseBuilder::error('An error occurred when trying to update the order', $error->getMessage());

        }
    }

    public function destroy(string $id): JsonResponse
    {
        try {

            $this->orderService->delete($id);

            return ResponseBuilder::success('Order deleted successfully');

        } catch (\Exception $error) {

            return ResponseBuilder::error('An error occurred when trying to delete the order', $error->getMessage(), 400);

        }
    }

}
