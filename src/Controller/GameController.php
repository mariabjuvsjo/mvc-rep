<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GameController extends AbstractController
{
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
        $session->clear();

        return $this->render('game/blackjack.html.twig');
    }

    /**
    * @Route("/game/blackjack/start", name="blackjack_process", methods={"POST"})
    */

    public function blackJackProcess(Request $request, SessionInterface $session)
    {
        $play = $request->request->get('play');

        $blackJack = $session->get("blackjack") ?? new \App\Cards\BlackJack();

        if ($play) {
            $blackJack->firstPlay();
            $session->set('blackjack', $blackJack);
        }

        return $this->redirectToRoute('blackjack-start');
    }

    /**
     * @Route("/game/blackjack/start", name="blackjack-start", methods={"GET", "HEAD"})
     */
    public function blackJackStart(SessionInterface $session): Response
    {
        $blackJack = $session->get('blackjack');

        $data = [
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

    public function blackJackGoProcess(Request $request, SessionInterface $session)
    {
        $stay  = $request->request->get('stay');
        $hit = $request->request->get("hit");
        $blackJack = $session->get("blackjack") ?? new \App\Cards\BlackJack();

        if ($hit) {
            $blackJack->playerHit();
            $session->set('blackjack', $blackJack);
            return $this->redirectToRoute('blackjack-start');
        }

        if ($stay) {
            return $this->redirectToRoute('blackjack-stop');
        }
    }

    /**
     * @Route("/game/blackjack/stop", name="blackjack-stop", methods={"GET", "HEAD"})
     */
    public function blackJackStop(SessionInterface $session): Response
    {
        $blackJack = $session->get("blackjack") ?? new \App\Cards\BlackJack();
        
        $data = [
        'gamestop' => $blackJack->gameStop(),
        'dealer' => $blackJack ->getDealerCards(),
        'player' => $blackJack ->getPlayerCards(),
        'dealerscore' => $blackJack ->getDealerScore(),
        'playerscore' => $blackJack->getPlayerScore(),
        ];

        return $this->render('game/blackjackstop.html.twig', $data);
    }
}
