<?php
namespace App\Service;
use App\Service\Data\UserData;

interface UserServiceInterface
{
    public function find(int $id): UserData;

    public function findAll(): ?array;

   
    public function updateInfo(UserData $userData);

    public function create(UserData $user): int;

    public function delete(int $id);

    public function parseDateTime(string $value, string $format): \DateTimeImmutable;
}
