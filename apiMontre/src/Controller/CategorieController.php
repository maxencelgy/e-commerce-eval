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
class CategorieController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    #[Route('/categories', name: 'app_categories')]
    public function index(ManagerRegistry $doctrine): JsonResponse
    {
        $categories = $doctrine
            ->getRepository(Categories::class)
            ->findAll();
        $data = [];

        foreach ($categories as $category) {
            $data[] = [
                'id' => $category->getId(),
                'name' => $category->getName(),
                'image' => $category->getImage(),
                'montres' => $category->getMontres(),
            ];
        }
        return $this->json($data);
    }

    //    INSERT MONTRES IN MY BDD
    #[Route('/categories/post', name: 'app_categories_post', methods: ['GET', 'POST'])]
    public function post(ManagerRegistry $doctrine, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $entityManager = $doctrine->getManager();
        $cat = new Categories();

        $cat->setName($data['name']);
        $cat->setName($data['image']);

//        Persist garde en tempon
        $entityManager->persist($cat);
//        FLUSH ca envoie
        $entityManager->flush();

        return $this->json('bien jouer hermano c\'est envoyer');
    }

//    UPDATE MONTRE
    #[Route('/categories/{id}/update', name: 'app_cat_post', methods: ['GET', 'PUT'])]
    public function update(ManagerRegistry $doctrine, $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        //Gere l envoie de données entre bdd et php
        $entityManager = $doctrine->getManager();

        $cat = $doctrine->getRepository(Categories::class)->findOneById($id);

        $cat->setName($data['name']);
        $cat->setName($data['image']);

        $entityManager->persist($cat);
        $entityManager->flush();

        return $this->json('Post Modifié');
    }

//    GET ONE MONTRE BY ID
    #[Route('/categories/{id}', name: 'get_categories_one', methods: ['GET'])]
    public function get(ManagerRegistry $doctrine, $id): JsonResponse
    {
        $category = $doctrine
            ->getRepository(Montres::class)
            ->findOneById($id);
        $data = [
            'id' => $category->getId(),
            'name' => $category->getName(),
            'image' => $category->getImage(),
        ];
        return $this->json($data);
    }

//    DELETE MONTRE BY ID
    #[Route('/categories/{id}/delete', name: 'delete_cat_one', methods: ['GET', 'DELETE'])]
    public function delete(ManagerRegistry $doctrine, $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $cat = $doctrine->getRepository(Categories::class)->findOneById($id);
        $entityManager->remove($cat);
        $entityManager->flush($cat);

        return $this->json('Ca a bien était delete');
    }

}
