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

            $data = $form->getData();

            $expression = "";

            if ($data["price"]) {
                $expression .= "product.price {$data["compare"]} {$data['price']}";
            }

            if ($data["startDate"]) {
                $expression .= " and date('now') >= date('{$data['startDate']->format('Y-m-d')}')";
            }

            if ($data["endDate"]) {
                $expression .= " and date('now') <= date('{$data['endDate']->format('Y-m-d')}')";
            }

            if ($expression) {
                $expression = "and {$expression}";
            }

            $discountAmount = $data["discountAmount"] / 100;
            $type = strToLower(self::normalize($data['type']->getType()));

            $expression = "product.type === '$type' {$expression} ? $discountAmount : 0";

            $discount->setRuleExpression($expression);
            $discount->setDiscountPercent($data['discountAmount']);
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
