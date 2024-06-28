<?php
declare(strict_types=1);
namespace App\Controller;
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Service\UserServiceInterface;
use App\Service\BasketServiceInterface;
use App\Service\OrderServiceInterface;
use App\Service\ProductServiceInterface;

use App\Service\UserService;
use App\Service\BasketService;
use App\Service\OrderService;
use App\Service\ProductService;

use App\Service\Data\OrderData;




use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class OrderController extends AbstractController
{
    private BasketServiceInterface $basketServiceInterface;
    private OrderServiceInterface $orderServiceInterface;
    private UserServiceInterface $userServiceInterface;
    private ProductServiceInterface $productServiceInterface;


    public function __construct(BasketService $basketService, OrderService $orderService, UserService $userService, ProductService $productService)
    {
        $this->basketServiceInterface = $basketService;
        $this->orderServiceInterface = $orderService;
        $this->userServiceInterface = $userService;
        $this->productServiceInterface = $productService;
    }

    public function addToOrders(int $productId): void {
        $user = $this->productServiceInterface->find($productId);
        $arrayOfBasket = $this->basketServiceInterface->findAllByCustomerId($productId);
        $arrayOfOrders = [];
        foreach ($arrayOfBasket as $item) {
            $arrayOfOrders[] = new OrderData(
                null,
                $item->getCustomerId(),
                $item->getProductId(),
                $item->getAmount(),
                $user->getPhone(),
                $user->getAdress()
            );
        }
        foreach ($arrayOfOrders as $order) {
            $this->orderServiceInterface->create($order);
        }
    }
    public function showAll(): Response {
        $allOrders = $this->orderServiceInterface->findAll();
        return $this->render('orders/list.html.twig', ['allOrders' => $allOrders]);    
    }
}