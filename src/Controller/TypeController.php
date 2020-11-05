<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Type;
use App\Repository\ProductRepository;
use App\Repository\TypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TypeController extends AbstractController
    /**
     * @Route("/type")
     */
{
    /**
     * @Route("/", name="type_index")
     */
    public function index(TypeRepository $repository)
    {

        $types = $repository->findAll();

        return $this->render('type/index.html.twig', [
            'types' => $types,
        ]);
    }

    /**
     * @Route("/{id}/view", name="type_view", requirements={"id":"\d+"})
     */
    public function viewType(Type $type)
    {
        return $this->render('type/view.html.twig', [
            'type' => $type,
        ]);
    }

}
