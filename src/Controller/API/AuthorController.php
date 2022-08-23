<?php

declare(strict_types=1);

namespace App\Controller\API;

use App\Entity\Author;
use App\Form\AdminAuthorType;
use App\Form\API\ApiAuthorType;
use App\DTO\SearchAuthorCriteria;
use App\Repository\AuthorRepository;
use App\Form\API\ApiSearchAuthorType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Flex\Response as FlexResponse;

class AuthorController extends AbstractController
{
    
    #[Route('/auteurs', 'app_api_author_create', methods:['POST'])]
    public function create( AuthorRepository $repository, Request $request): Response
    {
        //create formulaire
        $form= $this->createForm(ApiAuthorType::class);
        //
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $author=$form->getData();
            $repository->add($author, true);
            return $this->json($author, 201);
        }
        return $this->json($form->getErrors(), 400); 
    }


    #[Route('/auteurs', 'app_api_author_list', methods:['GET'])]  
    public function list(AuthorRepository $repository, Request $request ): Response   
    {
        // Création des critères de recherche
        $criteria = new SearchAuthorCriteria();

        // Création du formulaire de recherche
        $form = $this->createForm(ApiSearchAuthorType::class, $criteria);

        // On remplie le formulaire
        $form->handleRequest($request);

        // Récupération de tout les utilisateurs
        $authors = $repository->findByCriteria($criteria);

        // On retourne la collection d'utilisateur
        return $this->json($authors);      
    }    

    #[Route('auteurs/{id}', "app_api_author_show", methods: ['GET'])] 
    public function show(Author $author ): Response   
    {      
        return $this->json(($author));       
    }  


    #[Route('auteurs/{id}', 'app_api_author_update', methods:['PATCH'])]
    public function update( AuthorRepository $repository, Author $author, Request $request): Response{


        $form= $this->createForm(ApiAuthorType::class, $author, [
            'method'=>'PATCH',
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $author=$form->getData();
            $repository->add($author, true);
            return $this->json($author, 201);
        }
        return $this->json($form->getErrors(), 400); 
    }
    #[Route('/auteurs/{id}', 'app_api_author_remove', methods:['DELETE'])]
    public function remove(Author $author,  AuthorRepository $repository): Response
    {
        $repository->remove($author, true);
        return $this->json($author);
        
    }
}
