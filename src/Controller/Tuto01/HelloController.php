<?php

declare(strict_types=1);

namespace App\Controller\Tuto01;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController
{
    #[Route('/bonjour', name:'app_tuto01_hello_hello')]
    public function hello(Request $request): Response
    {
     return new Response('Hello everyone');   
    }
    #[Route('/bonjour/{name}', name:'app_tuto01_hello_hello2')]
    public function hello2(string $name): Response
    {
        return new Response('Bonjour'. $name);
    }
}
