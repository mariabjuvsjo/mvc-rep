<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class GameController extends AbstractController {
       
    /**
     * @Route("/game", name="game")
     */
    public function game(SessionInterface $session): Response

    {


    

      
  
        return $this->render('game/game.html.twig');
    }

            /**
     * @Route("/game/doc", name="doc")
     */
    public function doc(): Response
    {
        return $this->render('game/doc.html.twig');
    }



        /**
     * @Route("/game/blackjack", name="blackjack", methods={"GET","HEAD"})
     */
    public function blackJack(SessionInterface $session): Response
    {
        $blackJack = new \App\Cards\BlackJack();

        //$blackJack->firstPlay();

        $data = [
            "firstgame" => $blackJack->firstPlay(),
            "player" => $blackJack->getPlayerCards(),
            "dealer" => $blackJack->getDealerCards(),
            "playerscore" => $blackJack->getPlayerScore(),
            "gamestop" => var_dump($blackJack->gameStop()),
            "dealer2" => var_dump($blackJack->getDealerCards()),
            "dealerscore" => var_dump($blackJack->getDealerScore())

        ];
        return $this->render('game/blackjack.html.twig', $data);
    }

    /**
     * @Route("/game/blackjack", name="blackjack_process", methods={"POST"})
     */
    public function blackJackProcess(Request $request,
    SessionInterface $session): Response
    {   

       
        
        return $this->redirectToRoute('blackjack');
    }



 
}






//$session->clear("deck");
// $session->clear("mycard");
//$session->clear("left");


  // $deck1 = $this->createDeck();
        //**$deck1->getDeck();

        //$play  = $request->request->get('play');

        //$deck = $session->get("deck") ?? $deck1;

        // $left = $session->get("left") ?? $deck1->countCards();

         //$player = $session->get("player") ?? new \App\Cards\Hand;

        // $bank = $session->get("bank") ?? new \App\Cards\Hand;


             //$myCards = $session->get("mycard") ?? [];
            // $drawn = $deck->draw(2);
            // $left = $deck->countCards();
            // $player->addCardTHand($drawn);
             //$session->set('deck', $deck);
            // $session->set('left', $left);
            // $session->set('player', $player);

    
            // 'players' => $session->get('player'),
            // 'left' => $session->get('left')