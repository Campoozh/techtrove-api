<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Http\Requests\Order\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Interfaces\ModelServiceInterface;
use App\Interfaces\OrderServiceInterface;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Resources\Json\JsonResource;
use Ramsey\Uuid\Uuid as UuidValidator;

class OrderService implements OrderServiceInterface, ModelServiceInterface
{
    public function getAll(): array
    {
        $orders = Order::with('products')->get();

        return OrderResource::collection($orders)->resolve();
    }

    public function getOrderById(string $id): Order
    {
        if (!UuidValidator::isValid($id)) throw new \InvalidArgumentException('Invalid ID format. Should be UUID.', 400);

        $order = Order::with('products')->where('id', $id);

        if(!$order->exists()) throw new NotFoundException('Order was not found.');

        return $order->get()->first();
    }

    public function getUserOrders(string $userId): array
    {
        if (!UuidValidator::isValid($userId)) throw new \InvalidArgumentException('Invalid ID format. Should be UUID.', 400);

        $userOrders = Order::with('products')->where('user_id', $userId);

        if(!$userOrders->exists()) throw new NotFoundException('User orders were not found.');

        $userOrdersResponse = [];

        foreach ($userOrders->get() as $order)
            $userOrdersResponse[] = new OrderResource($order);

        return $userOrdersResponse;
    }

    public function formatToResponse(Model $model): JsonResource
    {
        return new OrderResource($model);
    }

    public function store(FormRequest $request): Order
    {

        $orderPayload = $request->only(['user_id', 'total']);

        $order = Order::create($orderPayload);

        $requestProducts = $request->input('products', []);

        $products = [];

        foreach ($requestProducts as $product) {
            $products[] = [
                "order_id" => $order->id,
                "product_id" => $product['product_id'],
                "quantity" => $product['quantity'],
            ];

        }

        $order->products()->attach($products);

        return $order;
    }

    public function update(FormRequest $request, string $id): Order
    {
        $order = $this->getOrderById($id);

        $order->update($request->only(['total']));

        $order->products()->detach();

        foreach ($request->products as $product) {
            $order->products()->attach($product['product_id'], [
                'quantity' => $product['quantity'],
            ]);
        }

        $order->load('products');

        return $order;
    }

    public function delete(string $id): bool
    {

        $order = $this->getOrderById($id);

        return $order->delete();

    }
}
