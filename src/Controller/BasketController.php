<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

    private $productRepository;

    /**
     *
     * @param EntityManagerInterface $entityManager
     * @param ProductRepository $productRepository
     */

    public function __construct(
        EntityManagerInterface $entityManager,
        ProductRepository $productRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->productRepository = $productRepository;
    }


    /**
     * @Route("/add", name="basket_add", methods={"POST"})
     * @param Request $request
     */
    public function add(Request $request): Response
    {
        if (!$request->isXmlHttpRequest()) {
            return $this->json(
                array(
                    "status" => "error",
                    "message" => "Error"
                ),
                400
            );
        }

        if (isset($request->request)) {
            $productId = $request->request->get("product_id");

            $product = $this->productRepository->find($productId);

            if (!$product) {
                return $this->json(
                    array(
                        "status" => false,
                        "message" => "!The product does not exist."
                    ),
                    400
                );
            }

            return $this->json(
                array(
                    "status" => true,
                    "message" => "!Product add to basket."
                ),
                200
            );
        }

        return $this->json(
            array(
                "status" => "error",
                "message" => "Error"
            ),
            400
        );
    }
}
