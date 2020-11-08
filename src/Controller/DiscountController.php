<?php

namespace App\Controller;


use App\Entity\Discount;
use App\Form\DiscountType;
use App\Repository\DiscountRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DiscountController extends AbstractController
{
    /**
     * @Route("/discount", name="discount_index")
     */
    public function index(DiscountRepository $repository): Response
    {
        $discounts = $repository->findAll();
        return $this->render('discount/index.html.twig',[
            'discounts'=>$discounts
        ]);
    }

    /**
     * @Route("/discount/new", name="discount_create")
     */

    public function create(Request $request, EntityManagerInterface $manager){
        $discount= new Discount();

        $form= $this->createForm(DiscountType::class, $discount);

        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($discount);
            $manager->flush();

            $this->addFlash(
                'success',
                "La nouvelle régle de solde a bien été enregister a bien été enregistrée"
            );

            return $this->redirectToRoute('discount_index', [
            ]);
        }
        return $this->render('discount/new.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
