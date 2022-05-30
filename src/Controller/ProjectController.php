<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ProjectController extends AbstractController
{
    /**
     * @Route("/proj", name="project")
     */
    public function projectStart(): Response
    {
        return $this->render('project/index.html.twig');
    }

     /**
     * @Route("/proj/about", name="about_proj")
     */
    public function projectAbout(): Response
    {
        return $this->render('project/about.html.twig');
    }

        /**
     * @Route("/proj/caribbean-poker", name="caribbean-poker", methods={"GET","HEAD"})
     */
    public function caribbeanPokerStart(): Response
    {
    
        //$session->clear();

        return $this->render('project/caribbean.html.twig');
    }


    /**
    * @Route("/proj/caribbean-poker/start", name="caribbean-poker_process", methods={"POST"})
    */
    public function caribbeanPokerProcess(Request $request, SessionInterface $session)
    {
        $play = $request->request->get('playpoker');
        $bet = $request->request->get('bet');

       

        return $this->redirectToRoute('caribbean-start');
    }

        /**
     * @Route("/proj/caribbean-poker/start", name="caribbean-start", methods={"GET", "HEAD"})
     */
    public function caribbeanStart(SessionInterface $session): Response
    {    
        $game = new \App\Project\Cgame();

        $game->firstPlay();

        $rules = new \App\Project\Crules($game);

        $data = [
            "player" => $game->getPlayerCards(),
            "dealer" => $game->getDealerCards(),
            "cards" => var_dump($rules)
        ];
   
        return $this->render('project/caribbeanstart.html.twig', $data);
    }
}