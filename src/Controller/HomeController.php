<?php

namespace App\Controller;

use http\Env\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController
{
    #[Route('/')]
    public function homepage()
    {
        die('Homepage active');
    }

    #[Route('/connected/{username}')]
    public function connected(string $username): Response
    {
        if($username){
            $title = 'Bienvenue '.$username;
        } else {
            $title = 'Compte invité';
        }
        return new Response($title);
    }

    #[Route('/qr-code')]
    public function qr_code_genereted()
    {
        die('page qr code');
    }
}
