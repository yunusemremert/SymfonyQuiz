<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/basket", name="basket.")
 */
class BasketController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var OrderRepository
     */
    private $orderRepository;

    /**
     *
     * @param EntityManagerInterface $entityManager
     * @param ProductRepository $productRepository
     * @param OrderRepository $orderRepository
     */

    public function __construct(
        EntityManagerInterface $entityManager,
        ProductRepository $productRepository,
        OrderRepository $orderRepository
    )
    {
        $this->entityManager     = $entityManager;
        $this->productRepository = $productRepository;
        $this->orderRepository   = $orderRepository;
    }

    /**
     * @Route("/add", name="basket_add", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request): JsonResponse
    {
        if (!$request->isXmlHttpRequest()) {
            return $this->json(
                array(
                    "status"  => "error",
                    "message" => "Error"
                ),
                400
            );
        }

        if (isset($request->request)) {
            $productId       = $request->request->get("product_id");
            $productQuantity = $request->request->get("product_quantity");

            $product      = $this->productRepository->find($productId);
            $orderProduct = $this->orderRepository->findOneBy([
                "user_id"    => $this->getUser()->getId(),
                "product_id" => $productId,
                "no"         => null
            ]);

            $order = new Order();

            if ($orderProduct) {
                $quantity = $orderProduct->getQuantity() + $productQuantity;
                $amount   = $product->getAmount() * $quantity;

                $orderProduct->setQuantity($quantity);
                $orderProduct->setAmount($amount);
            } else {
                $order->setUser($this->getUser());
                $order->setProductId($productId);
                $order->setQuantity($productQuantity);
                $order->setAmount($product->getAmount() * $productQuantity);
                $order->setCreatedAt(new \DateTime());

                $this->entityManager->persist($order);
            }

            $this->entityManager->flush();

            return $this->json(
                array(
                    "status"  => true,
                    "message" => "!Product add to basket."
                ),
                200
            );
        }

        return $this->json(
            array(
                "status"  => "error",
                "message" => "Error"
            ),
            200
        );
    }
}
