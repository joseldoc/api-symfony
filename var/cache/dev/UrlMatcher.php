<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/api/signup' => [[['_route' => 'user_signup', '_controller' => 'App\\Controller\\AuthController::siguUp'], null, ['POST' => 0], null, false, false, null]],
        '/api/category' => [
            [['_route' => 'add_category', '_controller' => 'App\\Controller\\CategoryController::add'], null, ['POST' => 0], null, false, false, null],
            [['_route' => 'get_category', '_controller' => 'App\\Controller\\CategoryController::getCategories'], null, ['GET' => 0], null, false, false, null],
        ],
        '/api/roles' => [
            [['_route' => 'get_roles', '_controller' => 'App\\Controller\\DroitController::getRoles'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'add_role', '_controller' => 'App\\Controller\\DroitController::add'], null, ['POST' => 0], null, false, false, null],
        ],
        '/api/users' => [
            [['_route' => 'add_users', '_controller' => 'App\\Controller\\UserController::add'], null, ['POST' => 0], null, false, false, null],
            [['_route' => 'get_all_user', '_controller' => 'App\\Controller\\UserController::getAll'], null, ['GET' => 0], null, false, false, null],
        ],
        '/api/doc.json' => [[['_route' => 'app.swagger', '_controller' => 'nelmio_api_doc.controller.swagger'], null, ['GET' => 0], null, false, false, null]],
        '/api/doc' => [[['_route' => 'app.swagger_ui', '_controller' => 'nelmio_api_doc.controller.swagger_ui'], null, ['GET' => 0], null, false, false, null]],
        '/api/login_check' => [[['_route' => 'login_check'], null, ['POST' => 0], null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_error/(\\d+)(?:\\.([^/]++))?(*:35)'
                .'|/api/(?'
                    .'|roles/(?'
                        .'|(\\d+)(?'
                            .'|(*:67)'
                        .')'
                        .'|([^/]++)(*:83)'
                    .')'
                    .'|users/([^/]++)(?'
                        .'|(*:108)'
                        .'|/activeOrDesactive(*:134)'
                        .'|(*:142)'
                    .')'
                .')'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        35 => [[['_route' => '_twig_error_test', '_controller' => 'twig.controller.preview_error::previewErrorPageAction', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        67 => [
            [['_route' => 'get_one_role', '_controller' => 'App\\Controller\\DroitController::getRole'], ['id'], ['GET' => 0], null, false, true, null],
            [['_route' => 'update_role', '_controller' => 'App\\Controller\\DroitController::update'], ['id'], ['PUT' => 0], null, false, true, null],
        ],
        83 => [[['_route' => 'delete_role', '_controller' => 'App\\Controller\\DroitController::delete'], ['id'], ['DELETE' => 0], null, false, true, null]],
        108 => [[['_route' => 'get_one_user', '_controller' => 'App\\Controller\\UserController::getOneUser'], ['id'], ['GET' => 0], null, false, true, null]],
        134 => [[['_route' => 'is_active_user', '_controller' => 'App\\Controller\\UserController::activeUser'], ['id'], ['PATCH' => 0], null, false, false, null]],
        142 => [
            [['_route' => 'delete_user', '_controller' => 'App\\Controller\\UserController::delete'], ['id'], ['DELETE' => 0], null, false, true, null],
            [['_route' => 'update_users', '_controller' => 'App\\Controller\\UserController::update'], ['id'], ['PUT' => 0], null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
