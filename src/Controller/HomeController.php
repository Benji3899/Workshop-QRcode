<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Forms;

class HomeController
{
    #[Route('/')]
    public function homepage()
    {


        Forms::createFormFactory();
        die('Homepage active');
    }

    #[Route('/connected/{username}')]
    public function connected(string $username = null): Response
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
