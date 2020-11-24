<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
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
}
