<?php

namespace App\Controller;

use App\Entity\Montres;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;


#[Route('/api', name: 'app_api')]
class UsersController extends AbstractController
{
    private $client;



    public function __construct(HttpClientInterface $client)
    {

        $this->client = $client;
    }


    #[Route('/users', name: 'app_users')]
    public function index(ManagerRegistry $doctrine): JsonResponse
    {
        $users = $doctrine
            ->getRepository(Users::class)
            ->findAll();
        $data = [];

        foreach ($users as $user) {
            $data[] = [
                'id' => $user->getId(),
                'first_name' => $user->getFirstName(),
                'last_name' => $user->getLastName(),
                'email' => $user->getEmail(),
            ];
        }
        return $this->json($data);
    }

    //    INSERT USER IN MY BDD
    #[Route('/users/post', name: 'app_user_post', methods: ['GET', 'POST'])]
    public function post(ManagerRegistry $doctrine, Request $request, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $entityManager = $doctrine->getManager();
        $user = new User();

        $user->setEmail($data['email']);
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($passwordHasher->hashPassword($user, $data['password']));

//        Persist garde en tempon
        $entityManager->persist($user);
//        FLUSH ca envoie
        $entityManager->flush();

        return $this->json('bien jouer hermano c\'est envoyer');
    }

//    UPDATE MONTRE
    #[Route('/users/{id}/update', name: 'app_user_update', methods: ['GET', 'PUT'])]
    public function update(ManagerRegistry $doctrine, $id, Request $request, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        //Gere l envoie de données entre bdd et php
        $data = json_decode($request->getContent(), true);
        $entityManager = $doctrine->getManager();

        $user = $doctrine->getRepository(User::class)->findOneById($id);

        $user->setEmail($data['email']);
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($passwordHasher->hashPassword($user, $data['password']));

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json('Post Modifié');
    }

//    GET ONE MONTRE BY ID
    #[Route('/users/{id}', name: 'get_one_users', methods: ['GET'])]
    public function get(ManagerRegistry $doctrine, $id): JsonResponse
    {
        $user = $doctrine
            ->getRepository(User::class)
            ->findOneById($id);

        $data = [
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'email' => $user->getEmail(),
        ];
        return $this->json($data);
    }

// GET ONE BY EMAIL
    #[Route('/users/email/', name: 'get_one_email', methods: ['GET', 'POST'])]
    public function getMail(ManagerRegistry $doctrine, UserPasswordHasherInterface $passwordHasher, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $user = $doctrine
            ->getRepository(User::class)
            ->findOneByEmail($data['email']);

        if (!empty($user)) {
            if ($passwordHasher->isPasswordValid($user, $data['password'])) {
                $data = [
                    'id' => $user->getId(),
                    'email' => $user->getEmail(),
                    'password' => $user->getPassword(),
                ];
                return $this->json([
                    'message' => 'Bienvenue',
                    'data' => $data
                ]);
            } else {
                return $this->json([
                    'message' => 'mdp pas bon',
                ]);
            }
        } else {
            return $this->json([
                'message' => 'Email pas bon',
            ]);
        }


    }

//    DELETE MONTRE BY ID
    #[Route('/users/{id}/delete', name: 'delete_one_user', methods: ['GET', 'DELETE'])]
    public function delete(ManagerRegistry $doctrine, $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $user = $doctrine->getRepository(Montres::class)->findOneById($id);
        $entityManager->remove($user);
        $entityManager->flush($user);

        return $this->json('Ca a bien était delete');
    }

}
