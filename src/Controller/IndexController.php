<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): ?Response
    {
        $userRole = $this->getUser()->getRoles()[0];

        if($userRole === 'ROLE_ADMIN'){
            return $this->redirectToRoute('admin.index');
        }

        return $this->render('order/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }
}
