<?php

declare(strict_types=1);

namespace App\DTO;

class Payment
{
    public ?string $cardNumber;

    public ?string $cardName;

    public ?string $dateExpiration;
    
    public ?string $cvc;
}
