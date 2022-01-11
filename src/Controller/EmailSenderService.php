<?php
namespace App\Controller;

/**
 * APIS class
 */
 class EmailSenderService
{
    
    public function sendEmail(string $email): bool
    {
    throw new \InvalidArgumentException("You can add only 2 more task in your list");
    }

}