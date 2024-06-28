<?php
namespace App\Repository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use App\Entity\Product;
class ProductRepository {
    private EntityManagerInterface $entityManager;
    private EntityRepository $repository;
    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Product::class);
    }
    public function findById(int $id): ?Product {
        return $this->entityManager->find(Product::class, $id);
    }
    public function store(Product $product): ?int {
        $this->entityManager->persist($product);
        $this->entityManager->flush();
        return $product->getId();
    }
    public function delete(Product $product): void {
        $this->entityManager->remove($product);
        $this->entityManager->flush();
    }
    public function findAll(): ?array {
        return $this->repository->findAll();
    }
    public function findBy(string $column, string $value): ?Product
    {
        return $this->repository->findOneBy([$column => $value]);
    }
}