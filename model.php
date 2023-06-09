<?php

function get_all_things() 
{
    global $is_development;
    $things = [];
    $connection = open_database_connection();
    $sql = "SELECT id, name FROM thing";
    try {
        $statement = $connection->query($sql);
        $result = $statement->fetchAll();
        $things = array_change_key_case_recursive($result, CASE_LOWER);
    } catch(PDOException $exception) {
        if ($is_development) {
            echo $exception->getMessage();
        }
    }
    close_database_connection($connection);
    
    return $things;
}


function get_thing_by_id($id) 
{
    global $is_development;
    $thing = [];
    $connection = open_database_connection();
    $sql = "SELECT id, name, shape, color FROM thing WHERE id=?";
    try {
        $statement = $connection->prepare($sql);
        $statement->bindParam(1, $id);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $thing = array_change_key_case_recursive($result, CASE_LOWER);
    } catch(PDOException $exception) {
        if ($is_development) {
            echo $exception->getMessage();
        }
    }
    close_database_connection($connection);
    
    return $thing;
}