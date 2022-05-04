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

        $blackJack = $session->get("blackjack") ?? new \App\Cards\BlackJack();

        //$firstGame = $session->get("firstgame") ?? $newGame->firstPlay();

    
        if($play) {
            $blackJack->firstPlay();
            $session->set('blackjack', $blackJack);

        }
        
        //$session->set('firstgame', $firstGame);
        
        
         
   

        return $this->redirectToRoute('blackjack-start');


     }

      /**
     * @Route("/game/blackjack/start", name="blackjack-start", methods={"GET", "HEAD"})
     */
     public function blackJackStart(SessionInterface $session) : Response {
        //$hit = $request->request->get('hit');
        //$stay  = $request->request->get('stay');

        $blackJack = $session->get('blackjack') ?? new \App\Cards\BlackJack();

        //$firstdraw = $session->get('firstgame');

        $data = [
            //'game' => var_dump($blackJack),
            'dealer' => $blackJack ->getDealerCards(),
            'player' => $blackJack ->getPlayerCards(),
            'dealerscore' => $blackJack ->getDealerScore(),
            'playerscore' => $blackJack->getPlayerScore(),
            'firstdraw' => $blackJack ->checkFirstDraw()
            




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
        $blackJack = $session->get("blackjack") ?? new \App\Cards\BlackJack();

     

        if($hit) {
            $blackJack->playerHit();
            $session->set('blackjack', $blackJack);
            return $this->redirectToRoute('blackjack-start');
        }

        if($stay) {
            return $this->redirectToRoute('blackjack-stop');
        }

        

     }

           /**
     * @Route("/game/blackjack/stop", name="blackjack-stop", methods={"GET", "HEAD"})
     */
    public function blackJackStop(SessionInterface $session) : Response {


        //$blackJack = $session->get('blackjack');

        //$firstdraw = $session->get('firstgame');

        $blackJack = $session->get("blackjack") ?? new \App\Cards\BlackJack();
        //$gameStop = $session->get("gamestop") ;


    $data = [
        'gamestop' => $blackJack->gameStop(),
        'dealer' => $blackJack ->getDealerCards(),
        'player' => $blackJack ->getPlayerCards(),
        'dealerscore' => $blackJack ->getDealerScore(),
        'playerscore' => $blackJack->getPlayerScore(),
        //'gamestop' => $blackJack->gameStop()

    ];



    return $this->render('game/blackjackstop.html.twig', $data);


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