<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CartController extends AbstractController
{
    private $client;
    private $montreCat = [];

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    #[Route('/cart', name: 'app_cart_home')]
    public function index(): Response
    {
        return $this->render('cart/index.html.twig', [

        ]);
    }

}
