<?php

declare(strict_types=1);

namespace App\Form\API;

use App\Form\SearchAuthorType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApiSearchAuthorType extends SearchAuthorType
{
  

    public function getBlockPrefix(): string
    {
        return '';
    }
}
