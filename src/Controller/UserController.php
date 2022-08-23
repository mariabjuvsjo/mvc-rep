<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
 

      /**
     * @Route("/proj/reg", name="create_user", methods={"GET"})
    */
    public function createuser(UserRepository $userRepository): Response
    {

        return $this->render('project/user/index.html.twig');
    }




      /**
     * @Route("/proj/reg", name="create_user_process", methods={"POST"})
     */
    public function createuserProcess(
        ManagerRegistry $doctrine,
        Request $request
    ): Response {
        $entityManager = $doctrine->getManager();

        $akro  = $request->request->get('akro');
        $password  = $request->request->get('password');
        $firstname  = $request->request->get('firstname');
        $lastname  = $request->request->get('lastname');
        $amount  = $request->request->get('amount');
        $email  = $request->request->get('email');

        $user = new User();
        $user->setAkronym($akro);
        $user->setPassword($password);
        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setAmount($amount);
        $user->setEmail($email);

        

        $entityManager->persist($user);

        $entityManager->flush();

        return new Response('Saved new product with id '.$user->getId());
    }

}

