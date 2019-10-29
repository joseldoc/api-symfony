<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the public 'App\Service\AuthService' shared autowired service.

include_once $this->targetDirs[3].'/vendor/symfony/framework-bundle/Controller/ControllerTrait.php';
include_once $this->targetDirs[3].'/vendor/symfony/framework-bundle/Controller/AbstractController.php';
include_once $this->targetDirs[3].'/vendor/friendsofsymfony/rest-bundle/Controller/ControllerTrait.php';
include_once $this->targetDirs[3].'/vendor/friendsofsymfony/rest-bundle/Controller/AbstractFOSRestController.php';
include_once $this->targetDirs[3].'/src/Service/AuthService.php';

$this->services['App\\Service\\AuthService'] = $instance = new \App\Service\AuthService(($this->services['App\\Service\\UserService'] ?? $this->load('getUserServiceService.php')));

$instance->setContainer(($this->privates['.service_locator.4RGsIK0'] ?? $this->load('get_ServiceLocator_4RGsIK0Service.php'))->withContext('App\\Service\\AuthService', $this));

return $instance;
