<?php
namespace App\Repository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use App\Entity\User;
class UserRepository {
    private EntityManagerInterface $entityManager;
    private EntityRepository $repository;
    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(User::class);
    }
    public function findById(int $id): ?User {
        return $this->entityManager->find(User::class, $id);
    }
    public function store(User $user): ?int {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return $user->getId();
    }
    public function delete(User $user): void {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }
    public function findAll(): ?array {
        return $this->repository->findAll();
    }
    public function findBy(string $column, string $value): ?User
    {
        return $this->repository->findOneBy([$column => $value]);
    }
}