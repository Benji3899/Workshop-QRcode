<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class QrCodeController extends AbstractController
{
    #[Route('/qrcode', name: 'app_qr_code')]

    public function index(Environment $twig): Response
    {
        $user = $this->getUser();
        return new Response($twig->render('qr_code/qr-code.html.twig', [
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
        ]));
    }
}
