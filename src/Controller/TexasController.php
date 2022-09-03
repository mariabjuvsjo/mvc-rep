<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\User;
use App\Entity\Outcome;
use App\Project\Cgame;
use App\Project\CplayerBal;
use App\Project\CcompareHands;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class TexasController extends AbstractController
{
    /**
    * @Route("/proj/texas/preflop", name="texas-poker_process", methods={"POST"})
    */
    public function texasPokerProcess(Request $request, SessionInterface $session)
    {
        $play = $request->request->get('playpoker');
        //$bet = $request->request->get('bet');

        //$totalBlind = $bet * 2;

        $user = $this->getUser();

        $balance = $user->getBalance();



        $texas = $session->get("texas") ?? new Cgame();
        $playerBal = $session->get("balance") ?? $balance;
        //$blinds = $session->get("blinds") ?? $totalBlind;

        if ($play) {
            $texas->firstPlay();
            //$texas->setPot($totalBlind);
            $session->set("texas", $texas);
            $session->set("balance", $playerBal);
        }
        return $this->redirectToRoute('texas-start');
    }

        /**
     * @Route("/proj/texas/preflop", name="texas-start", methods={"GET", "HEAD"})
     */
    public function texasStart(SessionInterface $session): Response
    {

        $texas = $session->get('texas');

        $playerBal = $session->get('balance');

        $data = [
        'player' => $texas ->getPlayerCard(),
        'dealer' => $texas ->getDealerCard(),
        //'playerBlind' => $texas ->getPot() / 2,
        'thePot' => $texas->getPot(),
        'playermoney' => $playerBal

        ];


        return $this->render('project/texasstart.html.twig', $data);
    }

      /**
     * @Route("/proj/texas/go", name="texas-go", methods={"POST"})
     */
    public function texasOption(Request $request, SessionInterface $session)
    {

        $fold = $request->request->get('fold');
        $raise = $request->request->get('raise');
        $amount = $request->request->get('amount');

        $texas = $session->get('texas');

        $playerBal = $session->get('balance');
        var_dump($amount);

        if ($fold) {
            return $this->redirectToRoute('texas-poker');
        }
        if ($raise) {
            $playerBal = $playerBal - $amount;
            $texas->setPot($amount * 2);
            $texas->theFlop();
            $session->set("balance", $playerBal);
            $session->set("texas", $texas);
        }

        return $this->redirectToRoute('texas-flop');
    }

         /**
     * @Route("/proj/texas/flop", name="texas-flop", methods={"GET", "HEAD"})
     */

    public function flop(SessionInterface $session): Response
    {

        $texas = $session->get('texas');

        $playerBal = $session->get('balance');

        $data = [
           'player' => $texas ->getPlayerCard(),
           'dealer' => $texas ->getDealerCard(),
           //'playerBlind' => $texas ->getPot() / 2,
           'thePot' => $texas->getPot(),
           'playermoney' => $playerBal,
           'community' => $texas->getCommunityCards()

           ];


           return $this->render('project/flop.html.twig', $data);
    }

       /**
     * @Route("/proj/texas/turn", name="texas-turn-process", methods={"POST"})
     */

    public function turnProcess(Request $request, SessionInterface $session)
    {

        $fold = $request->request->get('fold');
        $raise = $request->request->get('raise');
        $amount = $request->request->get('amount');
        $check = $request->request->get('check');

        $texas = $session->get('texas');

        $playerBal = $session->get('balance');


        if ($fold) {
            return $this->redirectToRoute('texas-poker');
        }
        if ($raise) {
            $playerBal = $playerBal - $amount;
            $texas->setPot($amount * 2);
            $texas->turn();
            $session->set("balance", $playerBal);
            $session->set("texas", $texas);
            return $this->redirectToRoute('texas-turn');
        }
        if ($check) {
            $texas->turn();
            $session->set("balance", $playerBal);
            $session->set("texas", $texas);
            return $this->redirectToRoute('texas-turn');
        }
    }

              /**
     * @Route("/proj/texas/turn", name="texas-turn", methods={"GET", "HEAD"})
     */

    public function turnGet(SessionInterface $session): Response
    {

        $texas = $session->get('texas');

        $playerBal = $session->get('balance');

        $data = [
            'player' => $texas ->getPlayerCard(),
            'dealer' => $texas ->getDealerCard(),
            //'playerBlind' => $texas ->getPot() / 2,
            'thePot' => $texas->getPot(),
            'playermoney' => $playerBal,
            'community' => $texas->getCommunityCards()

            ];


            return $this->render('project/turn.html.twig', $data);
    }


       /**
     * @Route("/proj/texas/river", name="texas-river-process", methods={"POST"})
     */

    public function riverProcess(Request $request, SessionInterface $session)
    {

        $fold = $request->request->get('fold');
        $raise = $request->request->get('raise');
        $amount = $request->request->get('amount');
        $check = $request->request->get('check');

        $texas = $session->get('texas');

        $playerBal = $session->get('balance');


        if ($fold) {
            return $this->redirectToRoute('texas-poker');
        }
        if ($raise) {
            $playerBal = $playerBal - $amount;
            $texas->setPot($amount * 2);
            $texas->river();
            $session->set("balance", $playerBal);
            $session->set("texas", $texas);
            return $this->redirectToRoute('texas-river');
        }
        if ($check) {
            $texas->river();
            $session->set("balance", $playerBal);
            $session->set("texas", $texas);
            return $this->redirectToRoute('texas-river');
        }
    }

              /**
     * @Route("/proj/texas/river", name="texas-river", methods={"GET", "HEAD"})
     */

    public function riverGet(SessionInterface $session): Response
    {

        $texas = $session->get('texas');

        $playerBal = $session->get('balance');

        $data = [
            'player' => $texas ->getPlayerCard(),
            'dealer' => $texas ->getDealerCard(),
            //'playerBlind' => $texas ->getPot() / 2,
            'thePot' => $texas->getPot(),
            'playermoney' => $playerBal,
            'community' => $texas->getCommunityCards()

            ];


            return $this->render('project/river.html.twig', $data);
    }

            /**
     * @Route("/proj/texas/gameover", name="texas-lastbet-process", methods={"POST"})
     */

    public function lastbetProcess(Request $request, SessionInterface $session)
    {

        $fold = $request->request->get('fold');
        $raise = $request->request->get('raise');
        $amount = $request->request->get('amount');
        $check = $request->request->get('check');

        $texas = $session->get('texas');

        $playerBal = $session->get('balance');


        if ($fold) {
            return $this->redirectToRoute('texas-poker');
        }
        if ($raise) {
            $playerBal = $playerBal - $amount;
            $texas->setPot($amount * 2);
            // KOLLA VEM SOM HAR DEN STARKASTE HANDEN
            // OM DATORN GE INTE POTEN TILL PLAYER
            //OM PLAYER GE HELA POTEN TILL PLAYERS KASSA
            $session->set("balance", $playerBal);
            $session->set("texas", $texas);
            return $this->redirectToRoute('texas-last-bet');
        }
        if ($check) {
             // KOLLA VEM SOM HAR DEN STARKASTE HANDEN
            // OM DATORN GE INTE POTEN TILL PLAYER
            //OM PLAYER GE HELA POTEN TILL PLAYERS KASSA
            $session->set("balance", $playerBal);
            $session->set("texas", $texas);
            return $this->redirectToRoute('texas-last-bet');
        }
        return $this->redirectToRoute('texas-go');
    }

    /**
     * @Route("/proj/texas/gameover/", name="texas-last-bet", methods={"POST"})
     */
    public function gameOverProcess(
        SessionInterface $session,
        ManagerRegistry $doctrine,
        UserRepository $userRepository
    ): Response {

        $entityManager = $doctrine->getManager();

        $user = $this->getUser();
        $outcome = new Outcome();

        $texas = $session->get('texas');


        $totalPot = $texas->getPot();
        $playerBal = $session->get('balance');

        $compare = new CcompareHands($texas);

        $winner = $session->get('winner') ?? $compare->compareHand();

        if (str_contains($winner, "You won")) {
            $user->setBalance($playerBal + $totalPot);
            $session->set("balance", $playerBal);
            $session->set('winner', $winner);
            $outcome->setResult("won");
        }
        if (str_contains($winner, "Draw")) {
            $newPot = $totalPot / 2;
            $user->setBalance($playerBal + $newPot);
            $session->set("balance", $playerBal);
            $session->set('winner', $winner);
            $outcome->setResult("draw");
        }
        if (str_contains($winner, "You lost")) {
            $user->setBalance($playerBal);
            $session->set('winner', $winner);
            $outcome->setResult("lose");
        }



        $user->addOutcome($outcome);
        $outcome->setUser($user);
        $entityManager->persist($outcome);
        $entityManager->persist($user);
        $entityManager->flush();

        $texas->resetPot();

        return $this->redirectToRoute('texas-end');
    }

     /**
     * @Route("/proj/texas/end/", name="texas-end", methods={"GET"})
     */
    public function texasEndGame(SessionInterface $session): Response
    {
        $texas = $session->get('texas');
        $winner = $session->get('winner');
        $playerBal = $session->get('balance');


        $data = [
            'player' => $texas ->getPlayerCard(),
            'dealer' => $texas ->getDealerCard(),
            //'playerBlind' => $texas ->getPot() / 2,
            'thePot' => $texas->getPot(),
            'playermoney' => $playerBal,
            'community' => $texas->getCommunityCards(),
            //'blabla' => var_dump($compare->checkPlayer()),
            //'bla'=> var_dump($compare->checkDealer()),
            'hihi' => $winner

            ];


            return $this->render('project/gameover.html.twig', $data);
    }
}
