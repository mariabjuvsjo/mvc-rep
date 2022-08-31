<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProjectController extends AbstractController
{
    /**
     * @Route("/proj", name="project")
     */
    public function projectStart(): Response
    {
        return $this->render('project/index.html.twig', ['user' => $this->getUser()]);
    }

     /**
     * @Route("/proj/about", name="about_proj")
     */
    public function projectAbout(): Response
    {
        return $this->render('project/about.html.twig');
    }

        /**
     * @Route("/proj/texas", name="texas-poker", methods={"GET","HEAD"})
     */
    public function texasPokerStart(SessionInterface $session): Response
    {
    
        $session->clear("texas");



        return $this->render('project/texas.html.twig');
    }


    /**
    * @Route("/proj/texas/preflop", name="texas-poker_process", methods={"POST"}) 
    */
    public function texasPokerProcess(Request $request, SessionInterface $session)
    {
        $play = $request->request->get('playpoker');
        //$bet = $request->request->get('bet');

        //$totalBlind = $bet * 2;

        $texas = $session->get("texas") ?? new \App\Project\Cgame();
        $playerBal = $session->get("balance") ?? new \App\Project\CplayerBal();
        //$blinds = $session->get("blinds") ?? $totalBlind;

        if($play) {
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
        'playermoney'=>$playerBal->getBalance()

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
        

        if($fold) {
            return $this->redirectToRoute('texas-poker'); 
        }
        if($raise) {
            $playerBal->setnegativeRes($amount);
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

     public function flop(SessionInterface $session): Response {

        $texas = $session->get('texas');

        $playerBal = $session->get('balance');

        $data = [
            'player' => $texas ->getPlayerCard(),
            'dealer' => $texas ->getDealerCard(),
            //'playerBlind' => $texas ->getPot() / 2,
            'thePot' => $texas->getPot(),
            'playermoney'=>$playerBal->getBalance(),
            'community'=> $texas->getCommunityCards()
    
            ];
        
       
            return $this->render('project/flop.html.twig', $data);
     }

       /**
     * @Route("/proj/texas/turn", name="texas-turn-process", methods={"POST"})
     */

     public function turnProcess(Request $request, SessionInterface $session) {

        $fold = $request->request->get('fold');
        $raise = $request->request->get('raise');
        $amount = $request->request->get('amount');
        $check = $request->request->get('check');

        $texas = $session->get('texas');

        $playerBal = $session->get('balance');
        

        if($fold) {
            return $this->redirectToRoute('texas-poker'); 
        }
        if($raise) {
            $playerBal->setnegativeRes($amount);
            $texas->setPot($amount * 2);
            $texas->turn();
            $session->set("balance", $playerBal);
            $session->set("texas", $texas);
            return $this->redirectToRoute('texas-turn');
        }
        if($check) {
            $texas->turn();
            $session->set("balance", $playerBal);
            $session->set("texas", $texas);
            return $this->redirectToRoute('texas-turn');
        }

     }

              /**
     * @Route("/proj/texas/turn", name="texas-turn", methods={"GET", "HEAD"})
     */

    public function turnGet(SessionInterface $session): Response {

        $texas = $session->get('texas');

        $playerBal = $session->get('balance');

        $data = [
            'player' => $texas ->getPlayerCard(),
            'dealer' => $texas ->getDealerCard(),
            //'playerBlind' => $texas ->getPot() / 2,
            'thePot' => $texas->getPot(),
            'playermoney'=>$playerBal->getBalance(),
            'community' => $texas->getCommunityCards()
    
            ];
        
       
            return $this->render('project/turn.html.twig', $data);
     }


       /**
     * @Route("/proj/texas/river", name="texas-river-process", methods={"POST"})
     */

    public function riverProcess(Request $request, SessionInterface $session) {

        $fold = $request->request->get('fold');
        $raise = $request->request->get('raise');
        $amount = $request->request->get('amount');
        $check = $request->request->get('check');

        $texas = $session->get('texas');

        $playerBal = $session->get('balance');
        

        if($fold) {
            return $this->redirectToRoute('texas-poker'); 
        }
        if($raise) {
            $playerBal->setnegativeRes($amount);
            $texas->setPot($amount * 2);
            $texas->river();
            $session->set("balance", $playerBal);
            $session->set("texas", $texas);
            return $this->redirectToRoute('texas-river');
        }
        if($check) {
            $texas->river();
            $session->set("balance", $playerBal);
            $session->set("texas", $texas);
            return $this->redirectToRoute('texas-river');
        }

     }

              /**
     * @Route("/proj/texas/river", name="texas-river", methods={"GET", "HEAD"})
     */

    public function riverGet(SessionInterface $session): Response {

        $texas = $session->get('texas');

        $playerBal = $session->get('balance');

        $data = [
            'player' => $texas ->getPlayerCard(),
            'dealer' => $texas ->getDealerCard(),
            //'playerBlind' => $texas ->getPot() / 2,
            'thePot' => $texas->getPot(),
            'playermoney'=>$playerBal->getBalance(),
            'community' => $texas->getCommunityCards()
    
            ];
        
       
            return $this->render('project/river.html.twig', $data);
     }

            /**
     * @Route("/proj/texas/gameover", name="texas-lastbet-process", methods={"POST"})
     */

    public function lastbetProcess(Request $request, SessionInterface $session) {

        $fold = $request->request->get('fold');
        $raise = $request->request->get('raise');
        $amount = $request->request->get('amount');
        $check = $request->request->get('check');

        $texas = $session->get('texas');

        $playerBal = $session->get('balance');
        

        if($fold) {
            return $this->redirectToRoute('texas-poker'); 
        }
        if($raise) {
            $playerBal->setnegativeRes($amount);
            $texas->setPot($amount * 2);
            // KOLLA VEM SOM HAR DEN STARKASTE HANDEN
            // OM DATORN GE INTE POTEN TILL PLAYER
            //OM PLAYER GE HELA POTEN TILL PLAYERS KASSA
            $session->set("balance", $playerBal);
            $session->set("texas", $texas);
            return $this->redirectToRoute('texas-last-bet');
        }
        if($check) {
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
     * @Route("/proj/texas/gameover", name="texas-last-bet", methods={"GET", "HEAD"})
     */

    public function lastbetGet(SessionInterface $session): Response {

        $texas = $session->get('texas');

        $totalPot = $texas->getPot();
        $playerBal = $session->get('balance');

        $compare = new \App\Project\CcompareHands($texas);

        $winner = $compare->compareHand();

        if (str_contains($winner, "You won")) {
            $playerBal->setPositiveRes($totalPot);
            $session->set("balance", $playerBal);

        }
        if (str_contains($winner, "Draw")) {
            $newPot = $totalPot / 2;
            $playerBal->setPositiveRes($newPot);
            $session->set("balance", $playerBal);

        }

        $texas->resetPot();


        //GÖR NGT SÅ ATT IF str_contains YOU WON SKA ALLA PENGAR IN PÅ KONTOT OM str_contains YOU LOST SKA PENGARNA INTE IN:
        //OM str_contains DRAW SKA HÄLFTEN AV PENGARNA TILLBAKA

        $data = [
            'player' => $texas ->getPlayerCard(),
            'dealer' => $texas ->getDealerCard(),
            //'playerBlind' => $texas ->getPot() / 2,
            'thePot' => $texas->getPot(),
            'playermoney'=>$playerBal->getBalance(),
            'community' => $texas->getCommunityCards(),
            //'blabla' => var_dump($compare->checkPlayer()),
            //'bla'=> var_dump($compare->checkDealer()),
            'hihi' => $winner
    
            ];
        
       
            return $this->render('project/gameover.html.twig', $data);
     }




             /**
     * @Route("/proj/texas/newgame", name="texas-newgame-process", methods={"POST"})
     */

    public function newgameProcess(Request $request, SessionInterface $session) {

        $exit = $request->request->get('exit');
        $continue = $request->request->get('continue');
  

        $texas = $session->get('texas');

        $playerBal = $session->get('balance');

        if($exit){
            return $this->redirectToRoute('project');
        }
        if($continue){
            $session->clear("texas");
            return $this->redirectToRoute('texas-poker');

        }
  
        return $this->redirectToRoute('project');
     }

     /**
      * @Route("/proj/reset", name="reset_database", methods={"GET"})
      */

    public function resetDatabase(ManagerRegistry $doctrine, UserPasswordHasherInterface $userPasswordHasher){
        $sql = [
            'DROP TABLE user;',
            'CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
            , password VARCHAR(255) NOT NULL, firstname VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, balance INTEGER NOT NULL);',
            'CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username);'   
        ];


        $entityManager = $doctrine->getManager();

        foreach ($sql as $query) {
            $statement = $entityManager->getConnection()->prepare($query);
            $statement->execute();
        }
        
        $userDoe = new User();

        $userDoe->setUsername("doe");
        $userDoe->setPassword(
            $userPasswordHasher->hashPassword(
                    $userDoe,
                    "doe"
                )
            );

            $entityManager->persist($userDoe);
            $entityManager->flush();

            $userAdmin = new User();

            $userAdmin->setUsername("admin");
            $userAdmin->setPassword(
                $userPasswordHasher->hashPassword(
                        $userAdmin,
                        "admin"
                    )
                );
            $userAdmin->setRoles(array('ROLE_ADMIN'));
                $entityManager->persist($userAdmin);
                $entityManager->flush();
        
            
        return $this->render('project/reset.html.twig');
    }

    







}