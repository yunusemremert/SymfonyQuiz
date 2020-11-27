<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/order", name="admin.order.")
 */
class OrderController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var OrderRepository
     */
    private $orderRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        OrderRepository $orderRepository
    )
    {
        $this->entityManager     = $entityManager;
        $this->orderRepository   = $orderRepository;
    }

    /**
     * @Route("", name="index")
     * @return Response
     */
    public function index(): Response
    {
        $orders = $this->orderRepository->getAllOrders();

        return $this->render('admin/order/index.html.twig', [
            'orders' => $orders
        ]);
    }

    /**
     * @Route("/approve/{no}", name="approve", methods={"POST"})
     * @param Request $request
     * @param Order $order
     * @return RedirectResponse
     */
    public function approve(Request $request, Order $order): RedirectResponse
    {
        if ($this->isCsrfTokenValid('approve'.$order->getNo(), $request->request->get('_token'))) {
            $order->setStatus(1);
            $this->entityManager->persist($order);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('admin.order.index');
    }
}