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
    public function game(): Response
    {
        return $this->render('game/game.html.twig');
    }

        /**
     * @Route("/game/blackjack", name="blackjack")
     */
    public function blackJack(): Response
    {
        return $this->render('game/blackjack.html.twig');
    }

         /**
     * @Route("/game/doc", name="doc")
     */
    public function doc(): Response
    {
        return $this->render('game/doc.html.twig');
    }
}