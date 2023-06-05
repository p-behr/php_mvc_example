<?php
require_once 'vendor/autoload.php';


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundataion\Response;
use Symfony\Component\Dotenv\Dotenv;


$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');
$is_development = ('dev' === $_ENV['APP_ENV']);
if ($is_development) {
    echo "DEVELOPMENT ENVIRONMENT<hr>";
}


$request = Request::createFromGlobals();
$uri = $request->getPathInfo();

if ('/' === $uri) {
    $response = list_things_action();
} 
elseif ('/show' === $uri && $request->query->has('id')) {
    $response = show_thing_action($request->query->get('id'));
} 
elseif ('/test' === $uri && $_ENV['APP_ENV'] === 'dev') {
    $response = testing_action();
} 
else {
    $response = not_found($uri);
}

$response->send();