<?php

namespace App\Interfaces;

use App\Exceptions\NotFoundException;
use App\Http\Requests\Order\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Testing\Exceptions\InvalidArgumentException;

interface OrderServiceInterface
{

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

}
