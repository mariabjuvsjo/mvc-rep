<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Cards\Card;
use App\Cards\Deck;
use App\Cards\Players;
use App\Cards\DeckWith2Joker;

class DrawController extends AbstractController
{
    private function addFlashPlayer($x, $y, $z)
    {
        if (($x * $y) > $z) {
            $this->addFlash("info", "To many Cards or Players Choose a lower number");
        }
    }

    private function setSessionDraw()
    {
        $myCards = $session->get("mycard") ?? [];
        $drawn = $deck->draw();
        $left = $deck->countCards();
        array_push($myCards, $drawn);
        $session->set('deck', $deck);
        $session->set('left', $left);
        $session->set('mycard', $myCards);
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
        $deck1 = new Deck();
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
            $session->clear();
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
        $deck1 = new Deck();
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
        }
        if ($clear) {
            $session->clear();

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

        $session->clear();

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


        $deck1 = new Deck();
        $deck1->shuffles();
        $deck1->getDeck();

        $startPlayers = new Players($players);


        $manyPlayers = $session->get("manyplayers") ?? $startPlayers->getPlayers();

        $deck = $session->get("deck") ?? $deck1;

        $left = $session->get("left") ?? $deck1->countCards();

        if ($play) {
            $this->addFlashPlayer($cards, $players, $deck1->countCards());
            foreach ($manyPlayers as $onePlayer) {
                for ($i = 0; $i < $cards; $i++) {
                    $card = $deck1->draw();
                    $onePlayer->addCardTHand($card);
                }

                $left = $deck->countCards();
                $session->set('deck', $deck);
                $session->set('left', $left);
                $session->set('manyplayers', $manyPlayers);
            }
        }
        if ($clear) {
            $session->clear();
        }

        return $this->redirectToRoute('deal', ["players" => $players, "cards" => $cards]);
    }

    /**
     * @Route("/card/deck2", name="deck2", methods={"GET","HEAD"})
     */
    public function deck2(): Response
    {
        $deck1 = new DeckWith2Joker();



        $data = [
        "decks" => $deck1->getDeck()
        ];



        return $this->render('card/deck2.html.twig', $data);
    }
}
