<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Http\Requests\Order\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Interfaces\OrderServiceInterface;
use App\Models\Order;
use Ramsey\Uuid\Uuid as UuidValidator;

//use App\Interfaces\OrderUpdateRequest;

class OrderService implements OrderServiceInterface
{

    public function getOrders(): array
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

    public function orderToResponse(Order $order): OrderResource
    {
        return new OrderResource($order);
    }

    public function store(OrderRequest $request): Order
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
                "price" => $product['price']
            ];

        }

        $order->products()->attach($products);

        return $order;
    }

    public function update(OrderRequest $request, string $id): Order
    {
        $order = $this->getOrderById($id);

        $order->update($request->only(['total']));

        foreach ($request->products as $product) {
            $order->products()->updateExistingPivot($product['product_id'], [
                'quantity' => $product['quantity'],
                'price' => $product['price']
            ]);
        }

        return $order;
    }

    public function delete(string $id): bool
    {

        $order = $this->getOrderById($id);

        return $order->delete();

    }
}
