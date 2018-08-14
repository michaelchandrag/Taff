<?php

$router = $di->getRouter();

// Define your routes here
$router->add(
    '/admlogin/routingLogin',
    [
        'controller' => 'admlogin',
        'action'     => 'login',
    ]
);
$router->handle();
