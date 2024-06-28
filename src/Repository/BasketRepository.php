<?php
namespace App\Repository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use App\Entity\Basket;
class BasketRepository {
    private EntityManagerInterface $entityManager;
    private EntityRepository $repository;
    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Basket::class);
    }
    public function find(int $id): Basket {
        return $this->repository->find($id);
    }
    public function findAllByCustomerId(int $customerId): ?array {
        return $this->repository->findAllBy(['customerId' => $customerId]);
    }
    public function store(Basket $basket): ?int {
        $this->entityManager->persist($basket);
        $this->entityManager->flush();
        return $basket->getItemId();
    }
    public function delete(Basket $basket): void {
        $this->entityManager->remove($basket);
        $this->entityManager->flush();
    }
    public function deleteAllByName(string $customerName): void {
        $allItems = $this->repository->findAllBy(['name' => $customerName]);
        foreach ($allItems as $item) {
            $this->entityManager->remove($item);
        }
        $this->entityManager->flush();
    }
    
}