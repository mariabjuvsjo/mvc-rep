<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
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
        //$blackJack = new \App\Cards\BlackJack();
        $session->clear("blackjack");
        //$blackJack->firstPlay();

        //if (!$session->get("blackjack")) {
        //    $session->set("blackjack", new \App\Cards\BlackJack());
        //}

        //$blackJack = $session->get("blackjack");

        //$blackJack = $session->get("blackjack") ?? new \App\Cards\BlackJack();

        return $this->render('game/blackjack.html.twig');
    }

     /**
     * @Route("/game/blackjack/start", name="blackjack_process", methods={"POST"})
     */

     public function blackJackProcess(Request $request, SessionInterface $session) : Response {
        $play = $request->request->get('play');

        $newGame = new \App\Cards\BlackJack();

        $newGame1 = $session->get("blackjack") ?? $newGame;

        //$firstGame = $session->get("firstgame") ?? $newGame->firstPlay();

    
        //$firstGame = 
        $newGame1->firstPlay();
        //$session->set('firstgame', $firstGame);
        $session->set('blackjack', $newGame1);
        
         
   

        return $this->redirectToRoute('blackjack-start');


     }

      /**
     * @Route("/game/blackjack/start", name="blackjack-start", methods={"GET", "HEAD"})
     */
     public function blackJackStart(SessionInterface $session) : Response {
        //$hit = $request->request->get('hit');
        //$stay  = $request->request->get('stay');

        $blackJack = $session->get('blackjack');

        //$firstdraw = $session->get('firstgame');

        $data = [
            'firstdraw' => $blackJack ->checkFirstDraw(),
            'dealer' => $blackJack ->getDealerCards(),
            'player' => $blackJack ->getPlayerCards(),
            'dealerscore' => $blackJack ->getDealerScore(),
            'playerscore' => $blackJack->getPlayerScore()
            //'game' => var_dump($blackJack)




        ];



        return $this->render('game/blackjackstart.html.twig', $data);

     }

       /**
     * @Route("/game/blackjack/go", name="blackjack-go", methods={"POST"})
     */

     public function blackJackGoProcess(Request $request, SessionInterface $session): Response {
            //$hit = $request->request->get('hit');
        $stay  = $request->request->get('stay');
        $hit = $request->request->get("hit");
        $blackJack = $session->get("blackjack");

        $gameStop = $session->get("gamestop") ?? "";

        if($hit) {
            $blackJack->playerHit();
            $session->set('blackjack', $blackJack);
        }

        if($stay) {
            $gameStop = $blackJack->gameStop();
            $session->set('gamestop', $gameStop);
            $session->set('blackjack', $blackJack);
        }

            $blackJack = $session->get("blackjack");
            $gameStop = $session->get("gamestop") ;


        $data = [
            'firstdraw' => "",
            'dealer' => $blackJack ->getDealerCards(),
            'player' => $blackJack ->getPlayerCards(),
            'dealerscore' => $blackJack ->getDealerScore(),
            'playerscore' => $blackJack->getPlayerScore(),
            'gamestop' => $gameStop

        ];



        return $this->render('game/blackjackstart.html.twig', $data);

     }

           /**
     * @Route("/game/blackjack/hit", name="blackjack-hit", methods={"GET", "HEAD"})
     */
    public function blackJackGo(SessionInterface $session) : Response {


        $blackJack = $session->get('blackjack');

        //$firstdraw = $session->get('firstgame');


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