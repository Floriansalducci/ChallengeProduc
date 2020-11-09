<?php

namespace App\Form;

use App\Entity\Discount;
use App\Entity\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DiscountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rule_expression',TextareaType::class,[
                'label'=> "Description de la régle de solde"])

            ->add('discount_percent',
                IntegerType::class,[
                    'label'=> "Pourcentage de réduction",
                    'attr'=> [
                        'placeholder'=> "Indiquer le pourcentage de réduction"
                ]]);


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Discount::class,
        ]);
    }
}
