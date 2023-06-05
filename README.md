### INSTALLATION
You must have PHP >= 8.1 installed.  
Info and installation instructions for IBM i can be found on the
[Seiden Group Blog](https://www.seidengroup.com/2021/12/01/php-8-1-released-for-ibm-i/)


Download the project into the document root (usually `htdocs`).  

3rd party components will be installed using [Composer](https://getcomposer.org/).  
Run the `composer install` command.   
Installation and usage instructions for IBM i can be found on the [Seiden Group Blog](https://www.seidengroup.com/php-documentation/installing-and-using-composer-with-communityplus-php/)  

Copy `.env.example` to `.env` and update configuration values.

<br>

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

Sensitive or changeable information (i.e. user names, passwords, environment) 
will be stored in environment variables rather than hard-coded values in the app.  These env vars are in `.env` (which was copied from .env.example during
install).  The Dotenv component is used to read the .env file and load the
environment variables.  Native environment variables will not be overwritten.
    
    $dotenv = new Dotenv();
    $dotenv->load(__DIR__.'/.env'); 


The APP_ENV variable will tell us if this is a development instance:

    $is_development = ('dev' === $_ENV['APP_ENV']);
    if ($is_development) {
        echo "DEVELOPMENT ENVIRONMENT<hr>";
    }



Get the URL of the incoming request

    $request = Request::createFromGlobals();
    $uri = $request->getPathInfo();



Route the request to the appropriate controller function.
If the user requests `index.php/show`, the route will be `/show`.
(note: you can use rewrite rules so the user doesn't have to
type the `index.php` part).

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


Send the response back to the client:

    $response->send();

### CONTROLLERS.PHP

The controller contains logic that updates the model (data) and/or view (user interface) in response to input from the users of the app.  User requests are 
routed to the controller functions.  The controller functions communicate
with the model to fetch data, and then update the view.

Controller functions return a Response:

    use Symfony\Component\HttpFoundation\Response;


If required, the controller will call functions in the model to fetch data:

    $things = get_all_things();

The data from the model will be sent to the view:

    $html = render_view_template('templates/list.php');

### MODEL.PHP

The model defines what data the app should contain and communicates with the database.  The specifics of opening and closing the database connections is contained in the `database.php` file, and the model uses those functions:

    $connection = open_database_connection();


The model functions execute SQL statements and return the data to the controller.

### VIEWS

The view defines how the app's data should be displayed. After the controller calls the model functions and has the required data, it will send that data to the view which crafts the HTML to be sent back to the client.  
Each view template will mostly be HTML, with a little bit of PHP to inject the values received from the controller into the page.

There is a view for each page of the website (i.e. `/templates/list.php` and `/templates/show.php`).. These view templates contain the specific content for that page.  The HTML header information is required for all the pages and has been extracted into `layout.php` which is then included in the other view templates.