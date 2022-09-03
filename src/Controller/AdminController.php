<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;

#[IsGranted('ROLE_ADMIN')]
class AdminController extends AbstractController
{
       /**
     * @Route("/admin", name="app_admin", methods={"GET"})
     */
    public function adminStart(UserRepository $userRepository): Response
    {

        $users = $userRepository->findAll();

        $data = [
            "users" => $users
        ];

        return $this->render('project/security/admin.html.twig', $data);
    }

        /**
 * @Route("/proj/profil/delete/{id}", name="profil_delete_by_id", methods={"GET"})
 */
    public function deleteUserById(
        UserRepository $userRepository,
        int $id
    ): Response {
        $user = $userRepository
        ->find($id);

        $data = [
        "deleteone" => $user
        ];

        return $this->render('project/security/deleteone.html.twig', $data);
    }

/**
 * @Route("/proj/profil/delete/{id}", name="profil_delete_by_id_process", methods={"POST"})
 */
    public function deleteUserProcess(
        ManagerRegistry $doctrine,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                "No user found for id " . $id
            );
        }

        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin');
    }
}
