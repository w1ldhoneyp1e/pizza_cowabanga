<?php
namespace App\Service;
use App\Service\Data\OrderData;

interface OrderServiceInterface
{
    public function find(int $orderId): OrderData;
    public function findAll(): ?array;

    public function create(OrderData $orderData): int;
   
    public function delete(int $orderId);

    public function update(OrderData $orderData);
    public function findBy(string $column, string $value): OrderData; 
}
