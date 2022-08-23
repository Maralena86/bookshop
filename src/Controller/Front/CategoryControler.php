<?php

declare(strict_types=1);

namespace App\Controller\Front;

use App\Entity\Category;
use App\Repository\BookRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
class CategoryControler extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/categorie/{id}', 'app_front_category_display')]
    public function display(Category $category, BookRepository $repository, int $id): Response
    {
        $books=$repository->findBooksCategory($id);
        return $this->render('front/categorie/liste.html.twig', [
            'category'=>$category,
            'books' => $books,
        ]);
    }
    
}
