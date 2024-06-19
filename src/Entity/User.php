<?php
declare(strict_types=1);
namespace App\Entity;

class User
{
    public function __construct(
        private ?int $userId,
        private string $firstName,
        private string $lastName,
        private ?string $middleName,
        private string $gender,
        private \DateTimeImmutable $birthDate,
        private string $email,
        private ?string $phone,
        private ?string $avatarPath)
    {

    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }
    public function getLastName(): ?string
    {
        return $this->lastName;
    }
    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }
    public function getId(): ?int
    {
        return $this->userId;
    }
    public function getAvatarPath(): ?string
    {
        return $this->avatarPath;
    }
    public function getBirthDate(): \DateTimeImmutable
    {
        return $this->birthDate; 
    }
    public function getGender(): string
    {
        return $this->gender;
    }
    public function getPhone(): ?string
    {
        return $this->phone;
    }
    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }
    public function setMiddleName(string $middleName): void
    {
        $this->middleName = $middleName;
    }
    public function setAvatarPath(string $avatarPath): void
    {
        $this->avatarPath = $avatarPath;
    }
    public function setBirthDay(string $birthDay): void
    {
        $this->birthDay = $birthDay;
    }
    public function setGender(string $gender): void
    {
        $this->gender = $gender;
    }
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
}