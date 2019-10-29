<?php

namespace App\Controller;

use App\Service\AuthService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View;
use Swagger\Annotations as SWG;

class AuthController extends AbstractFOSRestController
{
    private $_service;

    public function __construct(AuthService $authService)
    {
        $this->_service = $authService;
    }

    /**
     * @Rest\Post(
     *     path="/signup",
     *     name="user_signup"
     * )
     * @Rest\View(statusCode=201)
     * @SWG\Response(
     *     response=201,
     *     description="register a new user"
     * )
     * @Rest\RequestParam(name="name", description="name and firstname")
     * @Rest\RequestParam(name="username", description="username")
     * @Rest\RequestParam(name="email", description="email")
     * @Rest\RequestParam(name="password", description="password")
     * @Rest\RequestParam(name="phone", description="phone")
     * @SWG\Tag(name="Authentification")
     * @param ParamFetcher $paramFetcher
     * @return View
     */
    public function siguUp(ParamFetcher $paramFetcher)
    {
        return $this->_service->signUp($paramFetcher);
    }
}
