<?php 

use Symfony\Component\HttpFoundation\Response;

function list_things_action()
{
    $things = get_all_things();
    $html = render_view_template('templates/list.php', ['things' => $things]);
    return new Response($html);
}

function show_thing_action($id)
{
    $thing = get_thing_by_id($id);
    $html = render_view_template('templates/show.php', [
        'name' => $thing['name'], 
        'id' => $thing['id'],
        'shape' => $thing['shape'],
        'color' => $thing['color']
    ]);
    return new Response($html);
}

function testing_action()
{   
    $html = '<html><body><h1>TEST</h1></body></html>';
    return new Response($html);
}

function not_found($uri)
{
    $html = render_view_template('templates/notfound.php');
    return new Response($html);
}

function render_view_template($path, array $args)
{
    extract($args);
    
    // Start buffering so we don't send anything to the client
    ob_start();
    
    require $path;
    
    // Fetch the data from the buffer
    $html = ob_get_clean();
    
    return $html;
}