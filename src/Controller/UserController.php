<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\UserService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Security;

/**
 * Class DroitController
 * @package App\Controller
 * @Security(name="Bearer")
 * @SWG\Parameter(
 *   name="Authorization",
 *   in="header",
 *   required=true,
 *   type="string",
 *   default="Bearer TOKEN",
 *   description="Bearer token",
 * )
 * @IsGranted("ROLE_ADMIN", statusCode=404, message="Access denied")
 */
class UserController extends AbstractFOSRestController
{
    private $_service;

    public function __construct(UserService $userService)
    {
        $this->_service = $userService;
    }

    /**
     * @Rest\Post(
     *     path="/users",
     *     name="add_users"
     * )
     * @Rest\View(statusCode=201)
     * @SWG\Response(
     *     response=201,
     *     description="Add new user"
     * )
     * @Rest\RequestParam(name="name", description="name and firstname")
     * @Rest\RequestParam(name="username", description="username")
     * @Rest\RequestParam(name="email", description="email")
     * @Rest\RequestParam(name="password", description="password")
     * @Rest\RequestParam(name="address", description="address")
     * @Rest\RequestParam(name="zipCode", description="zipCode")
     * @Rest\RequestParam(name="phone", description="Telephone")
     * @Rest\RequestParam(name="city", description="city")
     * @Rest\RequestParam(name="role", description="role of user")
     * @SWG\Tag(name="User")
     * @param ParamFetcher $paramFetcher
     * @return View
     */
    public function add(ParamFetcher $paramFetcher): View
    {
        return $this->_service->add($paramFetcher);
    }

    /**
     * @Rest\Get(
     *     path="/users/{id}",
     *     name="get_one_user",
     * )
     * @Rest\View(statusCode=200)
     * @SWG\Response(
     *     response=200,
     *     description="return an pbject user"
     * )
     * @SWG\Tag(name="User")
     * @param User $user
     * @return View
     */
    public function getOneUser(User $user): View
    {
        return $this->_service->getOne($user);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Rest\Get(
     *     name="get_all_user",
     *     path="/users"
     * )
     * @Rest\View(statusCode=200)
     * @SWG\Response(
     *     response=200,
     *     description="resturn list of users"
     * )
     * @SWG\Tag(name="User")
     * @return View
     */
    public function getAll(): View
    {
        return $this->_service->getAll();
    }

    /**
     * @Rest\Patch(
     *     name="is_active_user",
     *     path="/users/{id}/activeOrDesactive"
     * )
     * @Rest\View(statusCode=200)
     * @SWG\Response(
     *     response=200,
     *     description="User is desactive"
     * )
     * @SWG\Tag(name="User")
     * @param User $user
     * @return View
     */
    public function activeUser(User $user): View
    {
        return $this->_service->activeUser($user);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Rest\Delete(
     *     name="delete_user",
     *     path="/users/{id}"
     * )
     * @Rest\View(statusCode=204)
     * @SWG\Response(
     *     response=200,
     *     description="User is deleted"
     * )
     * @SWG\Tag(name="User")
     * @param User $user
     * @return View
     */
    public function delete(User $user): View
    {
        return $this->_service->delete($user);
    }

    /**
     * @Rest\Put(
     *     path="/users/{id}",
     *     name="update_users"
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Update user"
     * )
     *
     * @param ParamFetcher $paramFetcher
     * @SWG\Tag(name="User")
     * @return View
     */
    public function update(User $user, ParamFetcher $paramFetcher): View
    {
        return $this->_service->update($user, $paramFetcher);
    }
}
