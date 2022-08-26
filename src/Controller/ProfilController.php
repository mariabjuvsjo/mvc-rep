<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;


class ProfilController extends AbstractController
{
    #[Route(path: '/proj/profil/{id}', name: 'app_profil')]
    public function profil(UserRepository $userRepository, ManagerRegistry $doctrine,
    int $id): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        //$error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        //$lastUsername = $authenticationUtils->getLastUsername();
        $user = $userRepository
        ->find($id);
      
        $data = [
            "profil" => $user
        ];
        return $this->render('project/security/profil.html.twig', $data);
    }

    /**
 * @Route("/proj/profil/update/{id}", name="profil_update_by_id", methods={"GET"})
 */
public function updateUserById(
    UserRepository $userRepository,
    int $id
): Response {
    $user = $userRepository
    ->find($id);

    $data = [
    "userupdate" => $user
    ];

    return $this->render('project/security/updateone.html.twig', $data);
}

/**
* @Route("/proj/profil/update/{id}", name="profil_update_by_id_process", methods={"POST"})
*/
public function updateUserProcess(
    ManagerRegistry $doctrine,
    Request $request,
    int $id
): Response {
    $entityManager = $doctrine->getManager();
    $user = $entityManager->getRepository(User::class)->find($id);

    $firstname  = $request->request->get('firstname');
    $lastname  = $request->request->get('lastname');
    $balance  = $request->request->get('balance');
    $image  = $request->request->get('image');

    if (!$user) {
        throw $this->createNotFoundException(
            "No User found for id " . $id
        );
    }

    $user->setFirstname($firstname);
    $user->setLastname($lastname);
    $user->setBalance($balance);
    $user->setImage($image);


    $entityManager->flush();

    return $this->redirectToRoute('app_profil', ['id' => $id]);
}
}

//['last_username' => $lastUsername, 'error' => $error]