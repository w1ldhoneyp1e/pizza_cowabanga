<?php
declare(strict_types=1);
namespace App\Entity;

class Product
{
    public function __construct(
        private ?int $productId,
        private string $name,
        private string $ingredients,
        private string $discription,
        private ?int $calories,
        private ?int $proteins,
        private ?int $fats,
        private ?int $carbs,
        private int $price,
        private string $imagePath)
    {

    }
    public function getId(): ?int
    {
        return $this->productId;
    }
    public function getName(): ?string
    {
        return $this->name;
    }
    public function getIngredients(): ?string
    {
        return $this->ingredients;
    }
    public function getDiscription(): ?string
    {
        return $this->discription;
    }
    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }
    public function getPrice(): ?int
    {
        return $this->price; 
    }
    public function getCalories(): ?int
    {
        return $this->calories;
    }
    public function getProteins(): ?int
    {
        return $this->proteins;
    }
    public function getFats(): ?int
    {
        return $this->fats;
    }
    public function getCarbs(): ?int
    {
        return $this->carbs;
    }
    
  
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function setIngredients(string $ingredients): void
    {
        $this->ingredients = $ingredients;
    }
    public function setDiscription(string $discription): void
    {
        $this->discription = $discription;
    }
    public function setImagePath(string $imagePath): void
    {
        $this->imagePath = $imagePath;
    }
    public function setPrice(int $price): void
    {
        $this->price = $price;
    }
    public function setCalories(int $calories): void
    {
        $this->calories = $calories;
    }
    public function setProteins(int $proteins): void
    {
        $this->proteins = $proteins;
    }
    public function setFats(int $fats): void
    {
        $this->fats = $fats;
    }
    public function setCarbs(int $carbs): void
    {
        $this->carbs = $carbs;
    }
}