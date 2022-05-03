<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CardController extends AbstractController
{
    /**
     * method for creating the deck with 52 cards
     */
    private function createDeck()
    {
        $suits = ["&hearts;", "&diams;", "&clubs;", "&spades;"];

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
     * @Route("/card", name="card")
     */
    public function card(): Response
    {
        return $this->render('card/card.html.twig');
    }

    /**
     * @Route("/card/deck", name="deck", methods={"GET","HEAD"})
     */
    public function deck(): Response
    {
        //$deck1 = $this->createDeck();
        $deck1 = new \App\Cards\Deck();
        $data = [
        "decks" => $deck1->getDeck()
        ];



        return $this->render('card/deck.html.twig', $data);
    }

    /**
     * @Route("/card/deck/shuffle", name="shuffle", methods={"GET","HEAD"})
     */
    public function shuffle(): Response
    {
        $deck1 = $this->createDeck();
        $deck1->shuffles();
        $data = [
        "decks" => $deck1->getDeck()
        ];



        return $this->render('card/shuffle.html.twig', $data);
    }


    /**
     * @Route("/card/deck/draw", name="draw", methods={"GET","HEAD"})
     */

    public function draw(SessionInterface $session): Response
    {
        $data = [
            'cards' => $session->get('mycard'),
            'left' => $session->get('left')
        ];



        return $this->render('card/draw.html.twig', $data);
    }

    /**
    * @Route(
    *      "/card/deck/draw",
    *      name="card-session-process",
    *      methods={"POST"}
    * )
    */
    public function sessionProcess(
        Request $request,
        SessionInterface $session
    ): Response {
        $deck1 = $this->createDeck();
        $deck1->shuffles();
        $deck1->getDeck();

        $deck = $session->get("deck") ?? $deck1;

        $draw  = $request->request->get('drawn');
        $clear = $request->request->get('clear');

        

        $left = $session->get("left") ?? $deck1->countCards();

        if ($draw) {
            $myCards = $session->get("mycard") ?? [];
            $drawn = $deck->draw();
            $left = $deck->countCards();
            array_push($myCards, $drawn);
            $session->set('deck', $deck);
            $session->set('left', $left);
            $session->set('mycard', $myCards);
        } elseif ($clear) {
            $session->clear("deck");
            $session->clear("mycard");
            $session->clear("left");
        }





        return $this->redirectToRoute('draw');
    }


    /**
    * @Route("/card/deck/draw/{number}", name="cards", methods={"GET","HEAD"})
    */
    public function drawNumber(int $number, SessionInterface $session): Response
    {
        $data = [
            'cards' => $session->get('mycard'),
            'left' => $session->get('left')
        ];



        return $this->render('card/draw-num.html.twig', $data);
    }

    /**
     * @Route("/card/deck/draw/{number}", name="card-number-process", methods={"POST"})
     */
    public function drawNumberProcess(
        Request $request,
        SessionInterface $session
    ): Response {
        $deck1 = $this->createDeck();
        $deck1->shuffles();
        $deck1->getDeck();
        $number = $request->request->get('numCards') ?? 0;
        $draw  = $request->request->get('drawn');
        $clear = $request->request->get('clear');

        $deck = $session->get("deck") ?? $deck1;

        $left = $session->get("left") ?? $deck1->countCards();



        if ($draw) {
            $myCards = $session->get("mycard") ?? [];
            $drawn = $deck->draw($number);
            $left = $deck->countCards();
            array_push($myCards, $drawn);
            $session->set('deck', $deck);
            $session->set('left', $left);
            $session->set('mycard', $myCards);
        } elseif ($clear) {
            $session->clear("deck");
            $session->clear("mycard");
            $session->clear("left");
            $number = 0;
        }

        return $this->redirectToRoute('cards', ["number" => $number]);
    }

    /**
     * @Route("/card/deck/deal/{players}/{cards}", name="deal", methods={"GET","HEAD"})
     */
    public function deal(int $players, int $cards, SessionInterface $session): Response
    {
        $data = [
            'players' => $session->get('manyplayers'),
            'left' => $session->get('left')


        ];

        $session->clear("deck");
        $session->clear("manyplayers");
        $session->clear("left");

        return $this->render('card/deal.html.twig', $data);
    }


    /**
     * @Route("/card/deck/deal/{players}/{cards}", name="deal-process", methods={"POST"})
     */
    public function dealProcess(
        Request $request,
        SessionInterface $session
    ): Response {
        $cards = $request->request->get('cards') ?? 0;
        $players = $request->request->get('players') ?? 0;
        $play  = $request->request->get('play');
        $clear  = $request->request->get('clear');


        $deck1 = $this->createDeck();
        $deck1->shuffles();
        $deck1->getDeck();

        $startPlayers = new \App\Cards\Players($players);


        $manyPlayers = $session->get("manyplayers") ?? $startPlayers->getPlayers();

        $deck = $session->get("deck") ?? $deck1;

        $left = $session->get("left") ?? $deck1->countCards();

        if ($play) {
            if (($cards * $players) > $deck1->countCards()) {
                $this->addFlash("info", "To many Cards or Players Choose a lower number");
            } else {
                foreach ($manyPlayers as $onePlayer) {
                    for ($i = 0; $i < $cards; $i++) {
                        $card = $deck1->draw();
                        $onePlayer->addCardTHand($card);
                    }
                }
                $left = $deck->countCards();
                $session->set('deck', $deck);
                $session->set('left', $left);
                $session->set('manyplayers', $manyPlayers);
            }
        } elseif ($clear) {
            $session->clear("deck");
            $session->clear("manyplayers");
            $session->clear("left");
        }

        return $this->redirectToRoute('deal', ["players" => $players, "cards" => $cards]);
    }

    /**
     * @Route("/card/deck2", name="deck2", methods={"GET","HEAD"})
     */
    public function deck2(): Response
    {
        $deck1 = $this->createDeck();

        $deck1->addCard(new \App\Cards\Card("J", "&#127199;", "black"));

        $deck1->addCard(new \App\Cards\Card("J", "&#127199;", "red"));



        $data = [
        "decks" => $deck1->getDeck()
        ];



        return $this->render('card/deck2.html.twig', $data);
    }
}
