<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountsRetrieving extends AbstractController
{
    #[Route('/get-client-accounts', name: 'client-accounts')]
    public function fetchAccountsByClientId(): Response
    {
        $response = new Response();

        $response->setContent('WTF TEST');
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'text/plain');

        $response->send();

        return $response;
    }
}
