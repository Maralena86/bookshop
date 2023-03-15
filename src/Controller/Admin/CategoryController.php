<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\DTO\SearchCategoryCriteria;
use App\Entity\Category;
use App\Form\SearchCategoryType;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Flex\Response as FlexResponse;

class CategoryController extends AbstractController
{
    #[Route('/admin/categorie/nouvelle', 'app_admin_category_create')]
    public function create(Request $request, CategoryRepository $repository): Response
    {
        if($request->isMethod('POST')){
            $name = $request->request->get('name');

            $category= new Category();
            $category->setName($name);
            $repository->add($category, true);
            return $this->redirectToRoute('app_admin_category_liste');

        }
        return $this->render('categoryExo/category/create.html.twig');
        
    }
    #[Route('admin/categorie', name:'app_admin_category_liste')]
    public function lister(CategoryRepository $repository, BookRepository $repo2, Request $request ): Response
    {
        //Créer la recherche (criteres)
        $search=new SearchCategoryCriteria();
        //créer le formulaire de recherche
        $form= $this->createForm(SearchCategoryType::class, $search);
        // Réaliser request
        $form->handleRequest($request);
        //recuperer les criteres filtres 
        $categories= $repository->findByCriteria($search);
        //recuperer les livres
        $books=$repo2->findAll();

        return $this->render('categoryExo/category/lister.html.twig', [
            'form' =>$form->createView(),
            'categories' => $categories,
            'books'=>$books,               
        ]);



    }
    #[Route('/admin/categorie/nouvelle/{id}/supprimer', 'app_admin_category_delete')]
    public function update(Request $request, AuthorRepository $repository, int $id): Response
    { 
        $category=$repository->find($id);
         
        if($request->isMethod('POST')){
            $name = $request->request->get('name');
            $category->setName($name);           
            $repository->add($category, true);
            return $this->redirectToRoute('app_admin_category_liste');
        }
        return $this->render('authorExo/category/update.html.twig', [
            'category' =>$category,
        ]);
    }

    #[Route('/admin/categorie/nouvelle/{id}/supprimer', 'app_admin_category_delete')]
    public function delete(Category $category, CategoryRepository $repository): Response
    {
        
        $repository->remove($category, true);
        return $this->redirectToRoute('app_admin_category_liste');

    }
}
