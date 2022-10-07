<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HomeController extends AbstractController
{
    private $client;
    private $montreCat = [];

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }


    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $response = $this->client->request(
            'GET',
            'http://127.0.0.1:8001/api/montres'
        );
        $montres = $response->toArray();

        $newResponse = $this->client->request(
            'GET',
            'http://127.0.0.1:8001/api/categories'
        );
        $categories = $newResponse->toArray();


        foreach ($montres as $montre) {

               $this->montreCat[$montre['categorie']][] = $montre;
        }

        return $this->render('home/index.html.twig', [
            'montres' => $montres,
            'categories' => $categories,
            'montresCat' => $this->montreCat,
        ]);
    }

    #[Route('/single/{id}', name: 'app_single')]
    public function single($id): Response
    {
        $response = $this->client->request(
            'GET',
            'http://127.0.0.1:8001/api/montres/' . $id
        );
        $montre = $response->toArray();


        return $this->render('single/index.html.twig', [
            'montre' => $montre,
        ]);
    }


}
