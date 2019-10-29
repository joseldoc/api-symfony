<?php

namespace App\Controller;

use App\Entity\Droit;
use App\Service\DroitService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Swagger\Annotations as SWG;

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
class DroitController extends AbstractFOSRestController
{
    private $_service;

    public function __construct(DroitService $droitService)
    {
        $this->_service = $droitService;
    }

    /**
     * @Rest\Get(
     *     path="/roles",
     *     name="get_roles"
     * )
     * @Rest\View(statusCode=200)
     * @SWG\Response(
     *     response=200,
     *     description="return list of roles"
     * )
     * @SWG\Tag(name="Role")
     */
    public function getRoles(): View
    {
        return $this->_service->getAll();
    }

    /**
     * @Rest\Get(
     *     path="/roles/{id}",
     *     name="get_one_role",
     *     requirements={"id"="\d+"}
     * )
     * @Rest\View(statusCode=200)
     * @SWG\Response(
     *     response=200,
     *     description="return object role"
     * )
     * @SWG\Tag(name="Role")
     */
    public function getRole(Droit $droit)
    {
        return $this->_service->getOne($droit);
    }

    /**
     * @Rest\Post(
     *     name="add_role",
     *     path="/roles"
     * )
     * @Rest\View(statusCode=201)
     * @Rest\RequestParam(name="name", description="name of role")
     * @SWG\Response(
     *     response=201,
     *     description="return a list of Role"
     * )
     * @SWG\Parameter(
     *       name="name",
     *      in="query",
     *      type="string",
     *      description="name of role"
     * )
     * @param ParamFetcher $paramFetcher
     * @SWG\Tag(name="Role")
     * @return View
     */
    public function add(ParamFetcher $paramFetcher): View
    {
        return $this->_service->add($paramFetcher);
    }

    /**
     * @Rest\Put(
     *     path="roles/{id}",
     *     name="update_role",
     *     requirements={"id"="\d+"}
     * )
     * @Rest\View(statusCode="200")
     * @Rest\RequestParam(name="name", description="name of role")
     * @SWG\Response(
     *     response=200,
     *     description="return an object of Role"
     * )
     * @SWG\Parameter(
     *       name="name",
     *      in="query",
     *      type="string",
     *      description="name of role"
     * )
     * @SWG\Tag(name="Role")
     * @param Droit $droit
     * @param ParamFetcher $paramFetcher
     * @return View
     */
    public function update(Droit $droit, ParamFetcher $paramFetcher): View
    {
        return $this->_service->update($droit, $paramFetcher);
    }

    /**
     * @Rest\Delete(
     *     path="/roles/{id}",
     *     name="delete_role"
     * )
     * @Rest\View(statusCode=204)
     * @SWG\Response(
     *     response=204,
     *     description="delete a role"
     * )
     * @SWG\Tag(name="Role")
     * @param Droit $droit
     * @return View
     */
    public function delete(Droit $droit): View
    {
        return $this->_service->delete($droit);
    }
}
