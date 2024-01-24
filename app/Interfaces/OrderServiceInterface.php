<?php

namespace App\Interfaces;

use App\Exceptions\NotFoundException;
use App\Http\Requests\Order\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Testing\Exceptions\InvalidArgumentException;

interface OrderServiceInterface
{
    public function getOrders(): array;

    /**
     * @throws NotFoundException
     * @throws InvalidArgumentException
     */
    public function getOrderById(string $id): Order;

    /**
     * @throws NotFoundException
     * @throws InvalidArgumentException
     */
    public function getUserOrders(string $userId): array;

    public function orderToResponse(Order $order): OrderResource;

    public function store(OrderRequest $request): Order;

    /**
     * @throws NotFoundException
     * @throws InvalidArgumentException
     */
    public function update(OrderRequest $request, string $id): Order;

    /**
     * @throws NotFoundException
     * @throws InvalidArgumentException
     */
    public function delete(string $id): bool;
}
