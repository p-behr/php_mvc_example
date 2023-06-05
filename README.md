// This file is the "front-controller";  all requests will 
// filter through here.  The front-controller will load any
// files/libraries that will be required, and then routes
// the incoming request to the appropriate controller.



// Bootstrap the application (load any required files/libraries).
// The autoloader will take care of importing files we need for
// every request.  Look in `composer.json` to see a list of files
// that are being auto loaded.
require_once 'vendor/autoload.php';



// Components from the Symfony framework that we'll be using.
// Required components are listed in `composer.json`. 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundataion\Response;
use Symfony\Component\Dotenv\Dotenv;



// Load the environment variables from the `.env` file.
// Environment variables are available in the $_ENV
// global variable.  Native environment variables are 
// not overwritten.
$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');
$is_development = ('dev' === $_ENV['APP_ENV']);
if ($is_development) {
    echo "DEVELOPMENT ENVIRONMENT";
}





// Get the URL of the incoming request
$request = Request::createFromGlobals();
$uri = $request->getPathInfo();





// Route the request to the appropriate controller function.
// If the user requests `index.php/show`, the route will be `/show`.
// (note: you can use rewrite rules so the user doesn't have to 
// type the `index.php` part).

