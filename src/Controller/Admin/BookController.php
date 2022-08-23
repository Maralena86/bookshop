<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Form\AdminBookType;
use App\Repository\BookRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_ADMIN')]
class BookController extends AbstractController
{
    #[Route('admin/livres/', name:'app_admin_book_liste')]
    public function lister(BookRepository $repository): Response
    {
        $books=$repository->findAll();
        return $this->render('bookExo/book/lister.html.twig', [
            'books' =>$books,
        ]);    
    }

    #[Route('/admin/livres/nouveau/', 'app_admin_book_create')]
    public function creater(Request $request, BookRepository $repository): Response
    {
        //Création formulaire
        $form=$this->createForm(AdminBookType::class);

        // Remplie le formulaire avec les données envoyé pour l'utilisateur
        $form->handleRequest($request);

        // test la validité du formulaire
        if($form->isSubmitted() && $form->isValid()){

            // Récupére l'auteur
            $author = $form->getData();

            $repository->add($author, true);

            return $this->redirectToRoute('app_admin_book_liste');

        }

        // Affiche le HTML
        return $this->render('bookExo/book/create.html.twig', [
            'form' => $form->createView(),
        ]);

    }
    #[Route('/admin/livres/nouveau/{id}', 'app_admin_book_update')]
    public function update(Book $book, Request $request, BookRepository $repository): Response
    {
       
        //Création formulaire
        $form=$this->createForm(AdminBookType::class, $book);

        // Remplie le formulaire avec les données envoyé pour l'utilisateur
        $form->handleRequest($request);

        // test la validité du formulaire
        if($form->isSubmitted() && $form->isValid()){

            // Récupére l'auteur
            $book = $form->getData();

            $repository->add($book, true);

            return $this->redirectToRoute('app_admin_book_liste');

        }

        // Affiche le HTML
        return $this->render('bookExo/book/update.html.twig', [
            'form' => $form->createView(),
        ]);


    }
    #[Route('/admin/livres/nouveau/{id}/supprimer', 'app_admin_book_delete')]
    public function delete(BookRepository $repository, int $id): Response
    {
        $book=$repository->find($id);
        $repository->remove($book, true);
        return $this->redirectToRoute('app_admin_book_liste');

    }

}