<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private '.service_locator.LzEFZ3Q' shared service.

return $this->privates['.service_locator.LzEFZ3Q'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($this->getService, [
    'droit' => ['privates', '.errored..service_locator.LzEFZ3Q.App\\Entity\\Droit', NULL, 'Cannot autowire service ".service_locator.LzEFZ3Q": it references class "App\\Entity\\Droit" but no such service exists.'],
], [
    'droit' => 'App\\Entity\\Droit',
]);