<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Contracts\HttpClient\HttpClientInterface;


class AuthController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    #[Route('/auth', name: 'app_auth')]
    public function index(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $user = [
                'email' => $request->get('email'),
                'password' => $request->get('password'),
            ];

            $response = $this->client->request(
                'POST',
                'http://127.0.0.1:8001/api/users/email/',
                [
                    'headers' => ['content-type:application/json'],
                    'body' => json_encode($user),
                ]);

            if ($response->toArray()['message'] == "Bienvenue"){
                $session = new Session();
                $session->set('user', $response->toArray()['data']);

//                dd($request->getSession());
//                $request->getSession()->set($session->set('user', $response->toArray()['data']);
                return $this->redirectToRoute('app_home');
            }
            else{
                return $this->render('auth/index.html.twig', [
                    'message' => $response->toArray()['message'],
                ]);
            }
        }
        return $this->render('auth/index.html.twig', [
            'controller_name' => 'AuthController',
        ]);
    }

    #[Route('/auth/sign', name: 'app_post', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $user = [
                'email' => $request->get('email'),
                'password' => $request->get('password'),
            ];

            $response = $this->client->request(
                'POST',
                'http://localhost:8001/api/users/post',
                [
                    'body' => json_encode($user),
                ]
            );
        }

        return $this->render('auth/sign/index.html.twig');
    }
}
