<?php
namespace App\Service;
use App\Service\Data\BasketData;
use App\Entity\Basket;
use App\Repository\BasketRepository;

class BasketService implements BasketServiceInterface
{
    private BasketRepository $basketRepository;

    public function __construct(BasketRepository $basketRepository)
    {
        $this->basketRepository =  $basketRepository;
    }   
    public function find(int $id): BasketData
    {
        $basket = $this->basketRepository->find($id);
        $basketData = $this->basketToBasketData($basket);
        return $basketData;
    }

    public function findAllByCustomerId(int $customerId): ?array
    {
        $allBasket = $this->basketRepository->findAllByCustomerId($customerId);
        $allBasketAsBasketData = [];
        foreach ($allBasket as $basket) {
            $allBasketAsBasketData[] = $this->basketToBasketData($basket);
        }
        return $allBasketAsBasketData;
    }
   
    public function update(BasketData $basketData)
    {
        $basket = $this->basketDataToBasket($basketData);
        $this->basketRepository->store($basket);
    }

    public function create(BasketData $basketData): int
    {
        $basket = $this->basketDataToBasket($basketData);
        return $this->basketRepository->store($basket);
    }

    public function delete(BasketData $basketData)
    {
        $id = $basketData->getItemId();
        $basket = $this->basketRepository->find($id);
        $this->basketRepository->delete($basket);
    }
    private function basketDataToBasket(BasketData $basketData): Basket
    {
        $basket = new Basket(
            null,
            $basketData->getCustomerId(),
            $basketData->getProductId(),
            $basketData->getAmount(),
        );
        return $basket;
    }
    private function basketToBasketData(Basket $basket): BasketData
    {
        $basketData = new BasketData(
            null,
            $basket->getCustomerId(),
            $basket->getProductId(),
            $basket->getAmount(),
        );
        return $basketData;
    }
}