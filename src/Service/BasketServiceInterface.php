<?php
namespace App\Service;
use App\Service\Data\BasketData;

interface BasketServiceInterface
{
    public function find(int $id): BasketData;

    public function findAllByCustomerId(int $customerId): ?array;

   
    public function update(BasketData $basketData);

    public function create(BasketData $basketData): int;

    public function delete(BasketData $basketData);

}
