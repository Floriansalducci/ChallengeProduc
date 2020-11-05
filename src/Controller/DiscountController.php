<?php

namespace App\Controller;

use App\Repository\DiscountRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DiscountController extends AbstractController
{
    /**
     * @Route("/discount", name="discount_index")
     */
    public function index(DiscountRepository $repository): Response
    {
        $discount = $repository->findAll();
        return $this->render('discount/index.html.twig');
    }
}
