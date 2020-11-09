<?php

namespace App\Command;

use App\Command\Engine;
use App\Entity\Product;
use App\Command\Language;
use App\Repository\DiscountRepository;
use App\Repository\TypeRepository;
use Symfony\Component\Mailer\Mailer;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\DiscountRulesRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class CalculateDiscountCommand extends Command
{
    protected static $defaultName = 'app:calculate-discount';

    private $language;
    private $engine;

    private $manager;
    private $type;
    private $product;
    private $discount;
    private $expressions;

    public function __construct(TypeRepository $type,ProductRepository $product, DiscountRepository $discount, EntityManagerInterface $manager)
    {
        $this->language = new Language();
        $this->engine = new Engine($this->language);

        $this->manager = $manager;
        $this->type = $type;
        $this->product = $product;
        $this->discount = $discount;
        $this->expressions = new ExpressionLanguage();
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('command calculate category of product discounted price')
            //->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            //->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);


        $type = $this->type->findAll();
        $product = $this->product->findAll();
        $discount = $this->discount->findAll();

        $engine = $this->engine;
        $manager = $this->manager;

        foreach ($discount as $discountRule) {

            $engine->addDiscountRule($discountRule->getRuleExpression());
        }

        // Array to send every morning
        $emailArray = [];
        foreach ($product as $types) {

            $discountPrice = number_format($engine->calculatePrice($product), 2, '.', '');

            if ($product->getPrice() != $discountPrice && $types->getDiscountPrice() != $discountPrice) {

                $types->setDiscountPrice($discountPrice);
                $manager->persist($product);
                $manager->flush();

                array_push($emailArray, [
                    "id"=>$product->getId(),
                    "name"=>$product->getName(),
                    "price"=>$product->getPrice(),
                    "discounted_price"=>$product->getdiscountedPrice(),
                    "type"=>$product->getType(),
                ]);
            }
        }

        if (!empty($emailArray)) {

            $message = (new \Swift_Message('Hello World'))
                ->setFrom('florian.salduccid@gmail.com')
                ->setTo('florian.salducci@gmail.com')
                ->setBody(
                    $this->renderView('emails/updateDiscount.html.twig', [
                        'products' => $emailArray
                    ]),
                    'text/html'
                );

            $mailer->send($message);
        }

        $io->success('Loop have been executed successfully, you can check the updated table!');

        return 0;
    }
}