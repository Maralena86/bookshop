<?php

declare(strict_types=1);

namespace App\Controller\Exo1;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CalculatriceController extends AbstractController
{
    #[Route('/calculatrice/additioner/{x}/{y}', name:'app_exo1_calculatrice_addition')]
    public function addition(float $x, float $y): Response
    {
        $resultat = $x + $y;   
        return $this->render('exo1/calculatrice/additioner.html.twig', [
            'x'=> $x,
            'y'=> $y,
            'resultat' => $resultat,
        ]);
    }

    #[Route('/calculatrice/soustraction/{x}/{y}', name:'app_exo1_calculatrice_soustraction')]
    public function soustraction (float $x, float $y): Response
    {   
        $resultat = $x - $y;   
        return $this->render('exo1/calculatrice/soustraction.html.twig', [
            'x'=> $x,
            'y'=> $y,
            'resultat' => $resultat,
        ]);
    }

    #[Route('/calculatrice/multiplication/{x}/{y}', name:'app_exo1_calculatrice_multiplication')]
    public function multiplication (float $x, float $y): Response
    {   
        $resultat = $x * $y;   
        return $this->render('exo1/calculatrice/multiplication.html.twig', [
            'x'=> $x,
            'y'=> $y,
            'resultat' => $resultat,
        ]);
    }

    #[Route('/calculatrice/division/{x}/{y}', name:'app_exo1_calculatrice_division')]
    public function division (float $x, float $y): Response
    {     
        if($y === 0.0){
            return $this->render('exo1/calculatrice/error.html.twig', [
                'x'=> $x,
                'y'=> $y,
            ]);    
        }
        $resultat = $x - $y;   
        return $this->render('exo1/calculatrice/division.html.twig', [
            'x'=> $x,
            'y'=> $y,
            'resultat' => $resultat,
        ]);
    }

    #[Route('/calculatrice/calculer/{x}/{y}', name:'app_exo1_calculatrice_calculer')]
    public function calculer (float $x, float $y, Request $request): Response
    { 
        $operation=$request->query->get('operation');
        
        switch($operation){
            case "plus":               
                return $this->addition($x,$y);
                break;
            case "-":               
                return $this->soustraction($x,$y);
                break;
            case "x":             
                return $this->multiplication($x,$y);
                break;
            case "/":
                if($y === 0.0){
                    return $this->render('exo1/calculatrice/error.html.twig');
                }            
                return $this->division($x,$y);
                break;
            default:
                return $this->render('exo1/calculatrice/calculer.html.twig', [
                    'x'=> $x,
                    'y'=> $y,
                ]);

        }
    }       
}

       

