<?php
declare(strict_types=1);
namespace App\Service\Data;

class UserData
{
    public function __construct(
        private ?int $userId,
        private string $email,
        private ?string $password,
        private ?string $firstName,
        private ?string $lastName,
        private ?string $phone,
        private ?string $adress,
        private ?string $avatarPath)
    {

    }
    public function getId(): ?int
    {
        return $this->userId;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function getPassword(): ?string
    {
        return $this->password;
    }
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }
    public function getLastName(): ?string
    {
        return $this->lastName;
    }
    public function getPhone(): ?string
    {
        return $this->phone;
    }
    public function getAdress(): ?string
    {
        return $this->adress;
    }
    public function getAvatarPath(): ?string
    {
        return $this->avatarPath;
    }
    
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }
    public function setAdress(string $gender): void
    {
        $this->gender = $gender;
    }
    public function setAvatarPath(string $avatarPath): void
    {
        $this->avatarPath = $avatarPath;
    }
}