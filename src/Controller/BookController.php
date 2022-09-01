<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {

        return $this->render('book/index.html.twig');
    }

      /**
     * @Route("/book/create", name="create_book", methods={"GET"})
    */
    public function createBook(): Response
    {

        return $this->render('book/create.html.twig');
    }




      /**
     * @Route("/book/create", name="create_book_process", methods={"POST"})
     */
    public function createBookProcess(
        ManagerRegistry $doctrine,
        Request $request
    ): Response {
        $entityManager = $doctrine->getManager();

        $title  = $request->request->get('title');
        $isbn  = $request->request->get('isbn');
        $author  = $request->request->get('author');
        $img  = $request->request->get('img');

        $book = new Book();
        $book->setTitle($title);
        $book->setIsbn($isbn);
        $book->setAuthor($author);
        $book->setImg($img);



        $entityManager->persist($book);

        $entityManager->flush();

        return $this->redirectToRoute("show_book");
    }

         /**
     * @Route("/book/show", name="show_book", methods={"GET"})
    */
    public function showBook(BookRepository $bookRepository): Response
    {
        $books = $bookRepository->findAll();

        //if ($books->getImg() === null | $books->getImg() === "" ) {
        //    $books->setImg('placeholder.png');
        //};

        $data = [
            "books" => $books
        ];


        return $this->render('book/show.html.twig', $data);
    }

    /**
 * @Route("/book/show/{id}", name="book_by_id")
 */
    public function showBookById(
        BookRepository $bookRepository,
        int $id
    ): Response {
        $book = $bookRepository
        ->find($id);

        $data = [
            "bookone" => $book
        ];

        return $this->render('book/showone.html.twig', $data);
    }

/**
 * @Route("/book/delete/{id}", name="book_delete_by_id", methods={"GET"})
 */
    public function deleteBookById(
        BookRepository $bookRepository,
        int $id
    ): Response {
        $book = $bookRepository
        ->find($id);

        $data = [
        "bookone" => $book
        ];

        return $this->render('book/deleteone.html.twig', $data);
    }

/**
 * @Route("/book/delete/{id}", name="book_delete_by_id_process", methods={"POST"})
 */
    public function deleteBookProcess(
        ManagerRegistry $doctrine,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Book::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                "No book found for id " . $id
            );
        }

        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute('show_book');
    }

/**
 * @Route("/book/update/{id}", name="book_update_by_id", methods={"GET"})
 */
    public function updateBookById(
        BookRepository $bookRepository,
        int $id
    ): Response {
        $book = $bookRepository
        ->find($id);

        $data = [
        "bookone" => $book
        ];

        return $this->render('book/updateone.html.twig', $data);
    }

/**
 * @Route("/book/update/{id}", name="book_update_by_id_process", methods={"POST"})
 */
    public function updateBookProcess(
        ManagerRegistry $doctrine,
        Request $request,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Book::class)->find($id);

        $title  = $request->request->get('title');
        $isbn  = $request->request->get('isbn');
        $author  = $request->request->get('author');
        $img  = $request->request->get('img');

        if (!$book) {
            throw $this->createNotFoundException(
                "No book found for id " . $id
            );
        }

        $book->setTitle($title);
        $book->setIsbn($isbn);
        $book->setAuthor($author);
        $book->setImg($img);


        $entityManager->flush();

        return $this->redirectToRoute('show_book');
    }
}
