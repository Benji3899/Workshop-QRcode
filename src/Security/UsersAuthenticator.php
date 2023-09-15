<?php

namespace App\Security;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class UsersAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    public function __construct(private UrlGeneratorInterface $urlGenerator)
    {
//        $this->urlGenerator = $urlGenerator;
    }

    public function authenticate(Request $request): Passport
    {
        // recupération de l'email
        $email = $request->request->get('email', '');

        // Dans la session, on enregistre le dernier nom d'utilisateur tapé
        $request->getSession()->set(Security::LAST_USERNAME, $email);

        // Création d'un passeport avec l'email et le mot de passe entrés par l'utilisateur
        return new Passport(
            // création du passeport en utilisant l'email et le mot de passe entré par l'utilisateur
            new UserBadge($email),
            new PasswordCredentials($request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),            ]
        );
    }

    // Function pour gérer la redirection après une authentification réussie
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // Si une cible de redirection est définie dans la session, redirigez l'utilisateur vers cette cible
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        // Sinon, redirigez l'utilisateur vers une URL spécifique (dans cet exemple, vers 'app_qr_code')
        return new RedirectResponse($this->urlGenerator->generate('app_qr_code'));
//        throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
    }

    // Méthode pour obtenir l'URL de la page de connexion
    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
