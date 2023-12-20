<?php

namespace App\Services;

use \Symfony\Bundle\SecurityBundle\Security;

class UserManager
{
    private $security;
    public $isLoggedIn; // Nouvelle propriété pour représenter l'état de connexion

    public function __construct(Security $security)
    {
        $this->security = $security;
        $this->updateConnectionStatus();
    }

    public function isConnected()
    {
        return $this->isLoggedIn;
    }

    public function isDisconnected()
    {
        return !$this->isLoggedIn;
    }

    // Met à jour l'état de connexion
    public function updateConnectionStatus()
    {
        $user = $this->security->getUser();
        $this->isLoggedIn = ($user !== null);
    }
}
