<?php
declare(strict_types=1);
namespace App\Entity;

class Basket
{
    public function __construct(
        private ?int $itemId,
        private int $customerId,
        private int $productId,
        private int $amount)
    {

    }
    public function getItemId(): ?int
    {
        return $this->itemId;
    }
    public function getCustomerId(): ?int
    {
        return $this->customerId;
    }
    public function getProductId(): ?int
    {
        return $this->productId;
    }
    public function getAmount(): ?int
    {
        return $this->amount;
    }
    
    
    public function setCustomerId(int $customerId): void
    {
        $this->customerId = $customerId;
    }
    public function setProductId(int $productId): void
    {
        $this->productId = $productId;
    }
    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }
    
}