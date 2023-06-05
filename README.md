### INDEX.PHP
This file is the "front-controller".  All requests will filter through here.
The front-controller is responsible for loading files and components that 
will be globally required and for routing the incoming request to the proper
controller function based on the request URI and parameters (and often the
request HTTP method).

<br>

The front-controller will first bootstrap the application by loading
any files that will be required.  The `autoloader.php` file will import
files automatically (without require statements).  
Look in `composer.json` to see a list of files that are being auto-loaded.

    require_once 'vendor/autoload.php';

<br>

The app will use some components from the Symfony framework. 
These components are installed using [Composer](https://getcomposer.org/).
You can see the list of required components in `composer.json`.
The components are downloaded into the `/vendor` folder.
The components are brought into the app with the `use` statement, which
is similar to a symbolic link.  

    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundataion\Response;
    use Symfony\Component\Dotenv\Dotenv;

<br>

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

