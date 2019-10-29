<?php

namespace App\Service;

use App\Entity\User;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

class AuthService extends AbstractFOSRestController
{

    private $_userService;

    public function __construct(UserService $userService)
    {
        $this->_userService = $userService;
    }

    public function signUp(ParamFetcher $paramFetcher): View
    {
        // Set Role when user subscribe from the website
        $paramFetcher->all()['role'] = 'ROLE_MARCHAND';
        return $this->_userService->add($paramFetcher);
    }
}
