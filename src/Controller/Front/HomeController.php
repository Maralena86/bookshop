<?php

declare(strict_types=1);

namespace App\Controller\Front;

use App\Form\SearchBookType;
use App\DTO\SearchBookCriteria;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', "app_front_home_home")]
    public function home(BookRepository $repository): Response
    {
        $books=$repository->findBooksDesc();
        
        return $this->render('front/home/liste.html.twig', [
            'books'=>$books,
        ]);
    }

    #[Route('/search', "app_front_home_search")]
    public function search(BookRepository $repository, Request $request): Response
    {

        $search = new SearchBookCriteria();

        $form=$this->createForm(SearchBookType::class, $search);

        $form->handleRequest($request);

        $books =$repository->findByCriteria($search);
            
        return $this->render("front/home/liste.html.twig", [
            'books' => $books,
            'form' => $form->createView()
        ]); 
    }
}
