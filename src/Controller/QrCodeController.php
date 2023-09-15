<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class QrCodeController extends AbstractController
{
    #[Route('/qrcode', name: 'app_qr_code')]
//    public function index(): Response
//    {
//        $user = $this->getUser();
//        return new Response(sprintf('Hello %s', $user->getNom()));
//
//        return $this->render('qr_code/qr-code.html.twig', [
//            'controller_name' => 'QrCodeController',
//        ]);
//    }

    public function index(Environment $twig): Response
    {

        return $this->render('qr_code/qr-code.html.twig', ['controller_name' => 'QrCodeController',]);

        $user = $this->getUser();
        return new Response($twig->render('qr_code/qr-code.html.twig', [
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
        ]));
    }
}
