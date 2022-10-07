<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Request;


class MontreController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }


    #[Route('/montre', name: 'app_montre')]
    public function index(): Response
    {

        $response = $this->client->request(
            'GET',
            'http://127.0.0.1:8001/api/montres'
        );
        $montres = $response->toArray();

        return $this->render('montre/index.html.twig', [
            'montres' => $montres,
        ]);
    }


    #[Route('/montre/create', name: 'app_create_montre', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $montre = [
                'name' => $request->get('name'),
                'price' => $request->get('price'),
                'description' => $request->get('description'),
                'image' => $request->get('image'),
                'categories_id' => $request->get('categories_id'),
            ];


            $response = $this->client->request(
                'POST',
                'http://127.0.0.1:8001/api/montres/post',
                [
                    'body' => json_encode($montre),
                ]
            );

        }


        $response = $this->client->request(
            'GET',
            'http://127.0.0.1:8001/api/categories'
        );
        $categories = $response->toArray();

        return $this->render('montre/create/index.html.twig', [
            'categories' => $categories,
        ]);
    }


}
