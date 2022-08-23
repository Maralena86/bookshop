<?php

declare(strict_types=1);

namespace App\Controller\API;

use App\Entity\User;
use App\Form\RegistrationType;
use App\DTO\SearchUserCriteria;
use App\Repository\UserRepository;
use App\Form\API\ApiSearchUserType;
use App\Form\API\ApiRegistrationType;
use App\Form\API\ApiSearchAuthorType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    // #[Route('/api/users', methods: ['GET'])]
    // public function list(UserRepository $repository, Request $request ): Response   
    // {
    //     // Création des critères de recherche
    //     $criteria = new SearchUserCriteria();

    //     // Création du formulaire de recherche
    //     $form = $this->createForm(ApiSearchAuthorType::class, $criteria);

    //     // On remplie le formulaire
    //     $form->handleRequest($request);

    //     // Récupération de tout les utilisateurs
    //     $users = $repository->findByCriteria($criteria);

    //     // On retourne la collection d'utilisateur
    //     return $this->json($users);      
    // }  
    
    // #[Route('/{id}', methods: ['GET'])] 
    // public function show(User $user ): Response   
    // {
        
    //     return $this->json(($user));       
    // }  
    // #[Route('/', methods: ['POST'])] 
    // public function create( UserRepository $repository, UserPasswordHasherInterface $hasher, Request $request): Response   
    // {
    //     //Création d'un formualire
    //     $form = $this->createForm(ApiRegistrationType::class);

    //     //On remplie le formulaire
    //     $form->handleRequest($request);

    //     //On test
    //     if($form->isSubmitted() && $form->isValid()){

    //         $user=$form->getData();  
    //         $user->setPassword($hasher->hashPassword($user, $user->getPassword()));

    //         $repository->add($user, true);
    //         return $this->json($user, 201); 
    //     }
        
    //     return $this->json($form->getErrors(), 400);       
    // }    
}

