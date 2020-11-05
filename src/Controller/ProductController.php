<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
    /**
     * @Route("/product")
     */
{
    /**
     * @Route("/", name="product_index")
     */
    public function index(ProductRepository $repository)
    {

        $products = $repository->findAll();

        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * @Route("/{id}", name="product_view", requirements={"id":"\d+"})
     */
    public function viewProduct(Product $product)
    {

        return $this->render('product/view.html.twig', [
            'product' => $product,
        ]);
    }
    /**
     * @Route("/list", name="product_list", methods={"GET"})
     */
    public function listProduct()
    {
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        return $this->render('product/list.html.twig', [
            'products' => $products,
        ]);
    }
}
