<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
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
     * @Route("/", name="index")
     * @return Response
     */
    public function index(): ?Response
    {
        $userRole = $this->getUser()->getRoles()[0];

        if($userRole === 'ROLE_ADMIN'){
            return $this->redirectToRoute('admin.index');
        }

        $products = $this->productRepository->findAll();

        return $this->render('index.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/order/basket", name="index.order_basket")
     * @return Response
     */
    public function basket(): Response
    {
        $orderProducts = $this->orderRepository->findByOrderProducts($this->getUser()->getId());

        return $this->render(
            'basket/index.html.twig', [
            'orderProducts' => $orderProducts
        ]);
    }

    /**
     * @Route("/order/delete/{id}", name="index.order_delete", methods={"DELETE"})
     * @param Request $request
     * @param Order $order
     * @return Response
     */
    public function delete(Request $request, Order $order): Response
    {
        if ($this->isCsrfTokenValid('delete'.$order->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($order);
            $entityManager->flush();
        }

        return $this->redirectToRoute('index.order_basket');
    }

    /**
     * @Route("/order/cart", name="index.order_cart")
     * @return Response
     */
    public function cart(): Response
    {
        return $this->render(
            'basket/cart.html.twig', [
            'orderProducts' => []
        ]);
    }
}
