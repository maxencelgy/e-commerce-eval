<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Montres;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;


#[Route('/api', name: 'app_api')]
class MontresController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }


    #[Route('/montres', name: 'app_montres')]
    public function index(ManagerRegistry $doctrine): JsonResponse
    {
        $montres = $doctrine
            ->getRepository(Montres::class)
            ->findAll();
        $data = [];

        foreach ($montres as $montre) {

            $data[] = [
                'id' => $montre->getId(),
                'name' => $montre->getName(),
                'price' => $montre->getPrice(),
                'description' => $montre->getDescription(),
                'image' => $montre->getImage(),
                'categorie' => $montre->getCategories()?->getName(),
                'user' => $montre->getUserId(),
            ];
        }
        return $this->json($data);
    }

    //    INSERT MONTRES IN MY BDD
    #[Route('/montres/post', name: 'montres_post', methods: ['GET', 'POST'])]
    public function post(ManagerRegistry $doctrine, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $entityManager = $doctrine->getManager();
        $post = new Montres();

        $post->setName($data['name']);
        $post->setPrice($data['price']);
        $post->setDescription($data['description']);
        $post->setImage($data['image']);
        $post->setCategories($entityManager->find(Categories::class, $data['categories_id']));
//        Persist garde en tempon
        $entityManager->persist($post);
//        FLUSH ca envoie
        $entityManager->flush();

        return $this->json('bien jouer hermano c\'est envoyer');
    }

//    UPDATE MONTRE
    #[Route('/montres/{id}/update', name: 'app_montres_post', methods: ['GET', 'PUT'])]
    public function update(ManagerRegistry $doctrine, $id, Request $request): JsonResponse
    {
        //Gere l envoie de données entre bdd et php
        $data = json_decode($request->getContent(), true);
        $entityManager = $doctrine->getManager();

        $post = $doctrine->getRepository(Montres::class)->findOneById($id);

        $post->setName($data['name']);
        $post->setPrice($data['price']);
        $post->setDescription($data['description']);
        $post->setImage($data['image']);

        $entityManager->persist($post);
        $entityManager->flush();

        return $this->json('Post Modifié');
    }

//    GET ONE MONTRE BY ID
    #[Route('/montres/{id}', name: 'get_one_montre', methods: ['GET'])]
    public function get(ManagerRegistry $doctrine, $id): JsonResponse
    {
        $montre = $doctrine
            ->getRepository(Montres::class)
            ->findOneById($id);

        $data = [
            'id' => $montre->getId(),
            'name' => $montre->getName(),
            'price' => $montre->getPrice(),
            'description' => $montre->getDescription(),
            'image' => $montre->getImage(),
            'categorie' => $montre->getCategories()?->getId(),
        ];
        return $this->json($data);
    }

//    DELETE MONTRE BY ID
    #[Route('/montres/{id}/delete', name: 'delete_one', methods: ['GET', 'DELETE'])]
    public function delete(ManagerRegistry $doctrine, $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $montre = $doctrine->getRepository(Montres::class)->findOneById($id);
        $entityManager->remove($montre);
        $entityManager->flush($montre);

        return $this->json('Ca a bien était delete');
    }

}
