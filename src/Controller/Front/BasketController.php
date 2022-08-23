<?php

declare(strict_types=1);

namespace App\Controller\Front;

use App\Entity\Book;
use App\Entity\User;
use App\Entity\Basket;
use App\Entity\Commande;
use App\Form\PaymentType;
use App\Repository\BasketRepository;
use App\Repository\CommandeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER')]
class BasketController extends AbstractController
{   
    #[Route('/mon_panier/{id}/ajouter', 'app_front_basket_add')]
    public function add( BasketRepository $repository, Book $book): Response
    {
        /** @var User $user */
        //On recupere le user
        $user =$this->getUser();
        //récuperer le panier de l'utilisateur
        $basket=$user->getBasket();
        //On ajoute le livre dans le panier
        $basket->addBook($book);  
        //Ajouter repository     
        $repository->add($basket, true);
        
        return $this->redirectToRoute("app_front_basket_display");      
    }


    #[Route('/mon_panier', 'app_front_basket_display')]
    public function display(/*Basket $basket*/):Response
    {
        // /** @var User $user */
        // $user =$this->getUser();
        // $basket=$user->getBasket();
        // $price=$basket->totalPrice();

        # code..
        return $this->render('front/basket/display.html.twig', 
        // [
        //     'basket' => $basket,
        //     'price' =>$price,
        // ]
        );
    }
    #[Route('/mon_panier/{id}/supprimer', 'app_front_basket_remove')]
    public function remove(BasketRepository $repository, Book $book):Response
    {
        /** @var User $user */
        $user =$this->getUser();
        $basket=$user->getBasket();
        $basket->removeBook($book);
        $price=$basket->totalPrice();
   
        # code..
        $repository->add($basket, true);

        return $this->render('front/basket/display.html.twig', [
            'basket' => $basket,
            'price' =>$price,
        ]);
    }


    #[Route('/mon_panier/validation', 'app_front_basket_validate')]
    public function validate(Request $request, CommandeRepository $repository): Response
    {
        //utilisateur
        /** @var User $user */
        $user =$this->getUser();
        $id=$user->getId();
        //Recuperer la commande de l'utilisateur
        $basket=$user->getBasket();
        $books= $basket->getBooks();
        $commande =new Commande();
        $commande->addUser($user);
                  

        //création de formulaire de la carte
        $form =$this->createForm(PaymentType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            //Changer la valeur de solde pour true
            foreach($books as $book){

                $book->setSold(true);
                $commande->addBook($book);
                
            }
            //Ajouter la nouvelle commande à la base de données
            $repository->add($commande, true);

            return $this->redirectToRoute('app_front_basket_confirmation', [
                'id'=>$id,
            ]);
        }
        return $this->render('front/basket/validate.html.twig', [
            'form'=>$form->createView(),
            
            
        ]);
        
    }
    #[Route('/commandes/{id}/confirmation', 'app_front_basket_confirmation')]
    public function confirmation(): Response
    {
        return $this->render('front/basket/confirmation.html.twig');
    }
    
   
    
}
