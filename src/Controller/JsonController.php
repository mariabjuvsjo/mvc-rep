<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class JsonController extends AbstractController
{
    private function createDeck()
    {
        $suits= ["&hearts;", "&diams;", "&clubs;", "&spades;"];

        $values = ["A", 2, 3, 4, 5, 6, 7, 8, 9, 10, "J", "Q", "K"];

        $color = "";

        $deck1 = new \App\Cards\Deck();

        foreach ($suits as $suit) {
            if ($suit == "&hearts;" || $suit == "&diams;") {
                $color = "red";
            } else {
                $color = "black";
            }
            foreach ($values as $value) {
                $deck1->addCard(new \App\Cards\Card($value, $suit, $color));
            }
        }
        return $deck1;
    }

    /**
     * @Route("/card/api/deck", name="apicard")
     */
    public function apicard(): Response
    {
        $deck1 = $this->createDeck();

        $data = [
            "deck" => $deck1->getDeck()
        ];


        return new JsonResponse($data);
    }
}
