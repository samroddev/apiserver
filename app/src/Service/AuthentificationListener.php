<?php

namespace App\Service;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\Security;

class AuthentificationListener 
{

    private $security;

    /**
     * 
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }


    /**
     * Appelé avant d'envoyer la réponse à l'utilisateur venant de se connecter.
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event): void
    {
        $user = $this->security->getUser();
        $data = $event->getData();
        $data['user'] = [
            'email' => $user->getUserIdentifier(),
            'roles' => $user->getRoles(),
        ];
        $event->setData($data);
    }


}