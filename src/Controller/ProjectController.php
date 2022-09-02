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
     * @Route("/proj/cleancode", name="app_cleancode")
     */
    public function projectCleanCode(): Response
    {
        return $this->render('project/cleancode.html.twig');
    }

    


    /**
     * @Route("/proj/texas", name="texas-poker", methods={"GET","HEAD"})
     */
    public function texasPokerStart(SessionInterface $session): Response
    {

        $session->clear();



        return $this->render('project/texas.html.twig');
    }



     /**
      * @Route("/proj/reset", name="reset_database", methods={"GET"})
      */

    public function resetDatabase(ManagerRegistry $doctrine, UserPasswordHasherInterface $userPasswordHasher)
    {
        $sql = [
            'DROP TABLE user;',
            'CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
            username VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
            , password VARCHAR(255) NOT NULL, firstname VARCHAR(255) DEFAULT NULL, 
            lastname VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, balance INTEGER NOT NULL);',
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



             /**
     * @Route("/proj/texas/newgame", name="texas-newgame-process", methods={"POST"})
     */

    public function newgameProcess(Request $request, SessionInterface $session)
    {

        $exit = $request->request->get('exit');
        $continue = $request->request->get('continue');


        $texas = $session->get('texas');

        $playerBal = $session->get('balance');

        if ($exit) {
            return $this->redirectToRoute('project');
        }
        if ($continue) {
            $session->clear();
            return $this->redirectToRoute('texas-poker');
        }

        return $this->redirectToRoute('project');
    }
}
