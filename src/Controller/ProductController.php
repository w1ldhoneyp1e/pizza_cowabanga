<?php
declare(strict_types=1);
namespace App\Controller;
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Service\UserServiceInterface;
use App\Service\ImageServiceInterface;
use App\Service\ProductServiceInterface;
use App\Service\BasketServiceInterface;

use App\Service\UserService;
use App\Service\ImageService;
use App\Service\ProductService;
use App\Service\BasketService;

use App\Service\Data\BasketData;
use App\Service\Data\ProductData;




use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class ProductController extends AbstractController
{
    private UserServiceInterface $userServiceInterface; 
    private ImageServiceInterface $imageServiceInterface; 
    private ProductServiceInterface $productServiceInterface;
    private BasketServiceInterface $basketServiceInterface;


    public function __construct(UserService $userService, ImageService $imageService, ProductService $productService, BasketService $basketService)
    {
        $this->userServiceInterface =  $userService;
        $this->imageServiceInterface =  $imageService;
        $this->productServiceInterface = $productService;
        $this->basketServiceInterface = $basketService;
    }

    public function main(): Response
    {
        $products = $this->productServiceInterface->findAll();
        return $this->render('products/catalog.html.twig', ['products' => $products]);
    }
    public function showProductInfo(int $id): Response {
        $product = $this->productServiceInterface->find($id);
        return $this->render('products/info.html.twig', ['product' => $product]);
    }
    public function showLoginPage(): Response {
        return $this->render('user/login.html.twig');
    }
    public function showAdminPage(): Response {
        return $this->render('products/admin.html.twig');
    }
    public function showBasketPage(): Response {
        return $this->render('basket/basket.html.twig');
    }
    public function addProductToBasket(string $identificator): void {
        $product = $this->productServiceInterface->findBy('name', $identificator);
        $basket = new BasketData(
            null,
            $customerId, //нужно получить из сессии
            $product->getId(),
            1
        );
        $this->basketServiceInterface->create($basket);
    }
    public function removeFromBasket($itemId): void {
        $item = $this->basketServiceInterface->find($itemId);
        $this->basketServiceInterface->delete($item);
    }
    public function addNewProduct(Request $request): Response {
        $requestArray = json_decode($request->getContent());
        $fileName = $this->imageServiceInterface->saveImageAsBase64($requestArray->img, $requestArray->name);
        $productData = new ProductData(
            null,
            $requestArray->name,
            $requestArray->ingredients,
            $requestArray->description,
            (int) $requestArray->calories,
            (int) $requestArray->proteins,
            (int) $requestArray->fats,
            (int) $requestArray->carbs,
            (int) $requestArray->price,
            $fileName
        );
        $id = $this->productServiceInterface->create($productData);
        return $this->redirectToRoute('show_product', ['id' => $id]); 
    }
    public function deleteProduct(int $id): Response {
        $this->productServiceInterface->delete($id);
        return $this->redirectToRoute('index'); 
    }
}