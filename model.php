<?php

require 'database.php';

function get_all_things() 
{
    $connection = open_database_connection();
    
    $result = $connection->query('SELECT id, title FROM post');
    
    $posts = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $posts[] = $row;
    }
    close_database_connection($connection);
    
    return $posts;
}


function get_thing_by_id($id) 
{
    $connection = open_database_connection();
    
    $result = $connection->query('SELECT created_at, title FROM post WHERE id=:id');
    $statement = $connection->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    
    close_database_connection($connection);
    
    return $row;
}