<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\DTO\SearchAuthorCriteria;
use App\Entity\Author;
use App\Form\AdminAuthorType;
use App\Form\SearchAuthorType;
use App\Repository\AuthorRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuthorController extends AbstractController
{
    #[Route('/admin/auteurs/nouveau/', 'app_admin_author_create')]
    public function creater(Request $request, AuthorRepository $repository): Response
    {
        //Création formulaire
        $form=$this->createForm(AdminAuthorType::class);

        // Remplie le formulaire avec les données envoyé pour l'utilisateur
        $form->handleRequest($request);

        // test la validité du formulaire
        if($form->isSubmitted() && $form->isValid()){

            // Récupére l'auteur
            $author = $form->getData();

            $repository->add($author, true);

            return $this->redirectToRoute('app_admin_author_liste');

        }
        // Affiche le HTML
        return $this->render('authorExo/author/create.html.twig', [
            'form' => $form->createView(),
        ]);       
    }

    #[Route('admin/auteurs', name:'app_admin_author_liste')]
    public function lister(AuthorRepository $repository, Request $request): Response
    {
        //créer indentaction pour la recherche 
        $search=new SearchAuthorCriteria();

        //création de form à partir le type form et avec la nouvelle indentation
        $form= $this->createForm(SearchAuthorType::class, $search);

        //Remplir le formulaire
        $form->handleRequest($request);

        $authors=$repository->findByCriteria($search);

        return $this->render('authorExo/author/lister.html.twig', [
            'authors' =>$authors,
            'form'=>$form->createView(),
        ]);    
    }
    #[Route('/admin/auteurs/nouveau/{id}', 'app_admin_author_update')]
    public function update(Author $author, Request $request, AuthorRepository $repository): Response
    {
        
        //Création formulaire
        $form=$this->createForm(AdminAuthorType::class, $author);

        // Remplie le formulaire avec les données envoyé pour l'utilisateur
        $form->handleRequest($request);

        // test la validité du formulaire
        if($form->isSubmitted() && $form->isValid()){

            // Récupére l'auteur
            $author = $form->getData();

            $repository->add($author, true);

            return $this->redirectToRoute('app_admin_author_liste');

        }

        // Affiche le HTML
        return $this->render('authorExo/author/update.html.twig', [
            'form' => $form->createView(),
        ]);

       

    }
    #[Route('/admin/auteurs/nouveau/{id}/supprimer', 'app_admin_author_supprimer')]
    public function delete(Author $author, AuthorRepository $repository): Response
    {
        $repository->remove($author, true);
        return $this->redirectToRoute('app_admin_author_liste');

    }

}
