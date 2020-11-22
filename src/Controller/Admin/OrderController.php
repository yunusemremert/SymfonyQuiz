<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/order", name="admin.order.")
 */
class OrderController extends AbstractController
{
    /**
     * @Route("", name="index")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('admin/order/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }
}