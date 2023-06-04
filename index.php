<?php
// This file is the "front-controller";  all requests will 
// filter through here.  The front-controller will load any
// files/libraries that will be required, and then routes
// the incoming request to the appropriate controller.


// Bootstrap the application (load any required files/libraries).
// The autoloader will take care of importing all the files we
// need.  Look in `composer.json` to see what's being imported.
require_once 'vendor/autoload.php';


// Components from Symfony framework that we'll be using
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundataion\Response;
use Symfony\Component\Dotenv\Dotenv;



// Load the environment variables from the `.env` file.
// Environment variables are available in the $_ENV
// global variable.
$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');
$is_development = ('dev' === $_ENV['APP_ENV']);

// Get the URL of the incoming request
$request = Request::createFromGlobals();
$uri = $request->getPathInfo();


// Route the request to the appropriate controller function.
// If the user requests `index.php/show`, the route will be `/show`.
// (note: you can use rewrite rules so the user doesn't have to 
// type the `index.php` part).


// "Root" is a request to list all things
if ('/' === $uri) {
    $response = list_things_action();
} 

// A request for a specific thing
elseif ('/show' === $uri && $request->query->has('id')) {
    $response = show_thing_action($request->query->get('id'));
} 

// TESTING PAGE
elseif ('/test' === $uri && $_ENV['APP_ENV'] === 'dev') {
    $response = testing_action();
} 

// Anything else is "not found"
else {
    $response = not_found($uri);
}

// Send the response back the client
$response->send();