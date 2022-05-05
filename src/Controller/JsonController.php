<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class JsonController extends AbstractController
{
    /**
     * @Route("/card/api/deck", name="apicard")
     */
    public function apicard(): Response
    {
        $deck1 = new \App\Cards\Deck();

        $data = [
            "deck" => $deck1->getDeck()
        ];


        return new JsonResponse($data);
    }
}
