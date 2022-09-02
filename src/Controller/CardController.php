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

class CardController extends AbstractController
{
    /**
     * method for creating the deck with 52 cards with dependecy injection
     *
      *  private function createDeck()
       * {
        *    $suits = ["&hearts;", "&diams;", "&clubs;", "&spades;"];
        *
        *    $values = ["A", 2, 3, 4, 5, 6, 7, 8, 9, 10, "J", "Q", "K"];
        *
        *   $color = "";
        *
        *   $deck1 = new \App\Cards\Deck();
        *
        *   foreach ($suits as $suit) {
        *       if ($suit == "&hearts;" || $suit == "&diams;") {
        *           $color = "red";
        *       } else {
        *           $color = "black";
        *       }
        *       foreach ($values as $value) {
        *           $deck1->addCard(new \App\Cards\Card($value, $suit, $color));
        *       }
        *    return $deck1;
        * }
    */
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
        $deck1 = new Deck();
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
        $deck1 = new Deck();
        $deck1->shuffles();
        $data = [
        "decks" => $deck1->getDeck()
        ];



        return $this->render('card/shuffle.html.twig', $data);
    }



}
