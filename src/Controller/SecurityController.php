<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\ProfileType;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/registration', 'app_security_registration')]
    public function registration(Request $request, UserPasswordHasherInterface $hasher, UserRepository $repository): Response
    {
        $form = $this->createForm(RegistrationType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $user= $form->getData();

            //Cripter le mot de passe
            $cryptedPassword= $hasher->hashPassword($user, $user->getPassword());
            $user ->setPassword($cryptedPassword);

            $repository->add($user, true);

            return $this->redirectToRoute('app_front_home_home');
        }
        return $this->render('security/registration.html.twig', [
        'form' => $form->createView(),

    ]);
    }

    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
    #[IsGranted('ROLE_USER')]
    #[Route('/mon-profile', 'app_security_myProfile')]
    public function myProfile(Request $request, UserRepository $repository): Response
    {
        $user=$this->getUser();

        $form =$this->createForm(ProfileType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){


            $repository->add($user, true);

            return $this->redirectToRoute('app_security_showProfile');
        }
        return $this->render('security/profile.html.twig', [
            'form' =>$form->createView(),
        ]);
        
    }
    #[Route('/mon-profile/show', 'app_security_showProfile')]
    public function showProfile(UserRepository $repository): Response
    {
        $users=$repository->findAll();
        return $this->render('security/show_profile.html.twig', [
            'users'=>$users
        ]);
        
    }
    
    
}
