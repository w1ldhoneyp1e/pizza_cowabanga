<?php
declare(strict_types=1);
namespace App\Entity;

class Order
{
    public function __construct(
        private ?int $orderId,
        private int $customerId,
        private int $productId,
        private int $amount,
        private string $phone,
        private string $adress)
    {

    }
    public function getOrderId(): ?int
    {
        return $this->orderId;
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
    public function getPhone(): ?string
    {
        return $this->phone;
    }
    public function getAdress(): ?string
    {
        return $this->adress;
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
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }
    public function setAdress(string $adress): void
    {
        $this->adress = $adress;
    }
    
}