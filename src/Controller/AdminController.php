<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin.")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("", name="index", methods={"GET"})
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    /**
     * @Route("/product", name="productList")
     * @return Response
     */
    public function productList(): Response
    {
        return new Response(
            '<div class="panel">Product List<div>'
        );
    }

    /**
     * @Route("/order", name="orderList")
     * @return Response
     */
    public function orderList(): Response
    {
        return new Response(
            '<div class="panel">Order List<div>'
        );
    }
}
