<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private '.service_locator.qc8HsAL' shared service.

return $this->privates['.service_locator.qc8HsAL'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($this->getService, [
    'params' => ['privates', '.errored..service_locator.qc8HsAL.FOS\\RestBundle\\Request\\ParamFetcher', NULL, 'Cannot autowire service ".service_locator.qc8HsAL": it references class "FOS\\RestBundle\\Request\\ParamFetcher" but no such service exists. Try changing the type-hint to "FOS\\RestBundle\\Request\\ParamFetcherInterface" instead.'],
    'user' => ['privates', '.errored..service_locator.qc8HsAL.App\\Entity\\User', NULL, 'Cannot autowire service ".service_locator.qc8HsAL": it references class "App\\Entity\\User" but no such service exists.'],
], [
    'params' => 'FOS\\RestBundle\\Request\\ParamFetcher',
    'user' => 'App\\Entity\\User',
]);
