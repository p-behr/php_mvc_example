<?php 

// We need to include the Symfony Reponse
use Symfony\Component\HttpFoundation\Response;


// Below we'll use functions from the model.php file,
// but we don't have a `require` statement here...that
// file has been autoloaded for us (see composer.json
// and index.php).


// A request to list all things
function list_things_action()
{
    $posts = get_all_things();
    $html = render_view_template('templates/list.php', ['posts' => $posts]);
    return new Response($html);
}

// A request to show a particular thing
function show_thing_action($id)
{
    $post = get_thing_by_id($id);
    $html = render_view_template('templates/show.php', ['post' => $post]);
    return new Response($html);
}

// TESTING
function testing_action()
{   
    $html = '<html><body><h1>TEST</h1></body></html>';
    return new Response($html);
}

// Any request not specifically handled is "not found"
function not_found($uri)
{
    $html = render_view_template('templates/notfound.php', ['post' => $post]);
}


function render_view_template($path, array $args)
{
    extract($args);
    
    // Use ob_start to buffer any output (we don't want 
    // to send anything back to the client yet).
    ob_start();
    
    // Call the view template
    require $path;
    
    // Use ob_get_clean to capture all the output from 
    // the view tempate and store it in a variable.
    $html = ob_get_clean();
    
    return $html;
}