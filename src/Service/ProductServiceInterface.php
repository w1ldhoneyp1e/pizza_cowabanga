<?php
namespace App\Service;
use App\Service\Data\ProductData;

interface ProductServiceInterface
{
    public function find(int $productId): ProductData;
    public function findAll(): ?array;

    public function create(ProductData $productData): int;
   
    public function delete(int $productId);

    public function update(ProductData $productData);
    public function findBy(string $column, string $value): ProductData; 
}
