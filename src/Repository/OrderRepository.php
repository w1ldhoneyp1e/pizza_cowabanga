<?php
namespace App\Repository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use App\Entity\Order;
class OrderRepository {
    private EntityManagerInterface $entityManager;
    private EntityRepository $repository;
    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Order::class);
    }
    public function find(int $id): Order {
        return $this->repository->find($id);
    }
    public function findAllByName(string $customerName): ?array {
        return $this->repository->findAllBy(['name' => $customerName]);
    }
    public function store(Order $order): ?int {
        $this->entityManager->persist($order);
        $this->entityManager->flush();
        return $order->getOrderId();
    }
    public function delete(Order $user): void {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }
    public function findAll(): ?array {
        return $this->repository->findAll();
    }
    public function findBy(string $column, string $value): ?Order
    {
        return $this->repository->findOneBy([$column => $value]);
    }
}