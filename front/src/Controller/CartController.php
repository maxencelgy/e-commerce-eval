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

    #[Route('/cart/{id}', name: 'app_cart_home')]
    public function index($id): Response
    {
        $response = $this->client->request(
            'GET',
            'http://127.0.0.1:8001/api/montres/' . $id
        );
        $montre = $response->toArray();
        return $this->render('cart/index.html.twig', [
            'montre' => $montre,
        ]);
    }
}
