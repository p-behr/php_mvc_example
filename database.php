<?php

function open_database_connection()
{
    global $is_development;
    $connection = null;
    $db_user = $_ENV['DB_USER'];
    $db_password = $_ENV['DB_PASSWORD'];
    $connection_string = build_connection_string();   
    
    try {
        $connection = new PDO($connection_string, $db_user, $db_password, array(
            PDO::ATTR_PERSISTENT => false, // if no persistence
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // show errors as exceptions
        ));
    } catch(PDOException $exception) {
        if ($is_development) {
            echo $exception->getMessage();
        }
    }
    return $connection;
}


function close_database_connection(&$connection)
{
    $connection = null;
}


function build_connection_string() 
{
    $connection_string = "";
    $type = $_ENV['DB_CONNECTION_TYPE'];
    
    if ('dsn' === $type) {
        $dsn = $_ENV['DB_DSN'];
        $connection_string = 'DSN='.$dsn;
    }
    elseif('db2i' === $type) {
        $driver = 'IBM i Access ODBC Driver';
        $system = $_ENV['DB_SYSTEM'];
        $naming = $_ENV['DB_NAM'];
        $libl = $_ENV['DB_LIBL'];
        $ccsid = $_ENV['DB_CCSID'];
        $connection_string = "odbc:DRIVER={$driver};SYSTEM={$system}";
        if (!empty($naming)) {
            $connection_string .= ";NAM=$naming";
        }
        if (!empty($libl)) {
            $connection_string .= ";DBQ=$libl";
        }
        if (!empty($ccsid)) {
            $connection_string .= ";CCSID=$ccsid";
        }
    } 
    elseif ('mysql' === $type) {
        $host = $_ENV['DB_MYSQL_HOST'];
        $database = $_ENV['DB_MYSQL_DATABASE'];
        $port = $_ENV['DB_MYSQL_PORT'];
        $connection_string = "mysql:host={$host};dbname={$database}";
        if (!empty($port)) {
            $connection_string .= ";port=$port";
        }
        
    }
    
    return $connection_string;
}


// Db2 for i will always return field names in UPPER CASE.
// This function will convert an array that has upper case field
// names into lower case so that the code doesn't have to change
// based on how the field names are defined in the database.
function array_change_key_case_recursive($arr, $case = CASE_LOWER)
{
    return array_map(function($item) use($case) {
        if(is_array($item))
            $item = array_change_key_case_recursive($item, $case);
        return $item;
    },array_change_key_case($arr, $case));
}