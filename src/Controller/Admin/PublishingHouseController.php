<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\PublishingHouse;
use App\Form\AdminPublishingHouseType;
use App\Repository\PublishingHouseRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PublishingHouseController extends AbstractController
{
    #[Route('admin/maisonLivre/nouvelle', 'app_admin_publishingHouse_create')]
    public function create(Request $request, PublishingHouseRepository $repository): Response
    {
        //création formulaire
        $form = $this->createForm(AdminPublishingHouseType::class);

        //Remplir avec les données de l'utilisateur
        $form->handleRequest($request);
        //Tester validation et envoie
        if($form->isSubmitted() && $form->isValid()){
            //Récuperer les données dans une variable
            $publishHouse = $form->getData();
            //Envoyer, ajouter les donnée à la base de données
            $repository->add($publishHouse, true);
            return $this->redirectToRoute('app_admin_publishingHouse_list');
        }

        return $this->render('publishExo/publish/create.html.twig', [
            'form'=>$form->createView(),
        ]);   
    }
    #[Route('admin/maisonLivre', 'app_admin_publishingHouse_list')]
    public function list(PublishingHouseRepository $repository): Response
    {
        //Récuperer le repository
        $houses = $repository->findAll();
        //Afficher le repository
        return $this->render('publishExo/publish/lister.html.twig',[
            'houses' => $houses,
        ]);
    }
    #[Route('admin/maisonLivre/nouvelle/{id}', 'app_admin_publishingHouse_update')]
    public function update(PublishingHouse $publishingHouse, Request $request, PublishingHouseRepository $repository): Response
    {
        //create
        $form = $this->createForm(AdminPublishingHouseType::class, $publishingHouse);
        //remplir
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            //Récuperer le remplisement de formulaire dans une variable
            $publishingHouse= $form->getData();

            //Ajouter dans la base de données
            $repository->add($publishingHouse, true);
            return $this->redirectToRoute('app_admin_publishingHouse_list');
        }
        return $this->render('publishExo/publish/update.html.twig', [
            'publishingHouse' => $publishingHouse,
            'form' => $form->createView(),
        ]);        
    }
    #[Route('admin/maisonLivre/{id}/supprimer', "app_admin_publishingHouse_delete")]
    public function delete(PublishingHouseRepository $repository, PublishingHouse $publishingHouse): Response
    {
        $repository->remove($publishingHouse, true);
        return $this->redirectToRoute('app_admin_publishingHouse_list');
        
    }
    
}
