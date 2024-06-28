<?php
namespace App\Service;
use App\Service\Data\OrderData;
use App\Entity\Order;
use App\Repository\OrderRepository;

class OrderService implements OrderServiceInterface
{

    private OrderRepository $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository =  $orderRepository;
    } 
    public function find(int $orderId): OrderData {
        $order = $this->orderRepository->find($orderId);
        $orderData = $this->orderToOrderData($order);
        return $orderData;
    }
    public function findAll(): ?array {
        $allOrders = $this->orderRepository->findAll();
        $allOrdersAsUserOrderData = [];
        foreach ($allOrders as $order) {
            $allOrdersAsUserOrderData[] = $this->orderToOrderData($order);
        }
        return $allOrdersAsUserOrderData;
    }

    public function create(OrderData $orderData): int {
        $order = $this->orderDataToOrder($orderData);
        return $this->orderRepository->store($order);
    }
   
    public function delete(int $orderId) {
        $this->orderRepository->delete($this->orderRepository->find($orderId));
    }

    public function update(OrderData $orderData) {
        $order = $this->orderDataToOrder($orderData);
        $this->orderRepository->store($order);
    }
    public function findBy(string $column, string $value): OrderData {
        $order = $this->orderRepository->findBy($column, $value);
        $orderData = $this->orderToOrderData($order);
        return $orderData;
    }

    private function orderDataToOrder(OrderData $orderData): Order
    {
        $order = new Order(
            null,
            $orderData->getCustomerId(),
            $orderData->getProductId(),
            $orderData->getAmount(),
            $orderData->getPhone(),
            $orderData->getAdress()
        );
        return $order;
    }
    private function orderToOrderData(Order $order): OrderData
    {
        $orderData = new OrderData(
            null,
            $order->getCustomerId(),
            $order->getProductId(),
            $order->getAmount(),
            $order->getPhone(),
            $order->getAdress()
        );
        return $orderData;
    }
}