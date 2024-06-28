<?php
namespace App\Service;
use App\Service\Data\ProductData;
use App\Entity\Product;
use App\Repository\ProductRepository;

class ProductService implements ProductServiceInterface
{

    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository =  $productRepository;
    } 
    public function find(int $productId): ProductData {
        $product = $this->productRepository->findById($productId);
        $productData = $this->productToProductData($product);
        return $productData;
    }
    public function findAll(): ?array {
        $allProducts = $this->productRepository->findAll();
        $allProductsAsProductData = [];
        foreach ($allProducts as $product) {
            $allProductsAsProductData[] = $this->productToProductData($product);
        }
        return $allProductsAsProductData;
    }

    public function create(ProductData $productData): int {
        $product = $this->productDataToProduct($productData);
        return $this->productRepository->store($product);
    }
   
    public function delete(int $productId) {
        $this->productRepository->delete($this->productRepository->findById($productId));
    }

    public function update(ProductData $productData) {
        $product = $this->productDataToProduct($productData);
        $this->productRepository->store($product);
    }
    public function findBy(string $column, string $value): ProductData {
        $product = $this->productRepository->findBy($column, $value);
        $productData = $this->productToProductData($product);
        return $productData;
    }

    private function productDataToProduct(ProductData $productData): Product
    {
        $product = new Product(
            $productData->getId(),
            $productData->getName(),
            $productData->getIngredients(),
            $productData->getDiscription(),
            $productData->getCalories(),
            $productData->getProteins(),
            $productData->getFats(),
            $productData->getCarbs(),            
            $productData->getPrice(),
            $productData->getImagePath()
        );
        return $product;
    }
    private function productToProductData(Product $product): ProductData
    {
        $productData = new ProductData(
            $product->getId(),
            $product->getName(),
            $product->getIngredients(),
            $product->getDiscription(),
            $product->getCalories(),
            $product->getProteins(),
            $product->getFats(),
            $product->getCarbs(),   
            $product->getPrice(),         
            $product->getImagePath()
        );
        return $productData;
    }
}