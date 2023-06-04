<?php

function open_database_connection()
{
    $connection = null;
    $connection_string = "";
    $dsn = $_ENV['DB_DSN'];
    $type = $_ENV['DB_CONNECTION_TYPE'];
    
    // Connect using a DSN
    if ('dsn' === $type) {
        $connection_string = 'DSN='.$dsn;
    }
    // Connect to Db2 using ad-hoc connection string
    elseif('db2i' === $type) {
        
    } 
    // Connect to mysql using ad-hoc connection string
    elseif ('mysql' === $type) {
        $host = $_ENV['DB_MYSQL_HOST'];
        $database = $_ENV['DB_MYSQL_DATABASE'];
        $port = $_ENV['DB_MYSQL_PORT'];
        $db_user = $_ENV['DB_MYSQL_USER'];
        $db_password = $_ENV['DB_MYSQL_PASS'];
        $connection_string = "mysql:host={$host};dbname={$database}";
        if (!empty($port)) {
            $connection_string .= ";port=$port";
        }
        
    }
    
    // Create a connection to the database
    try {
        $connection = new PDO($connection_string, $db_user, $db_password, $options);
    } catch(PDOException $exception) {
        if ($is_development) {
            $msg = $exception->getMessage();
        } else {
            $msg = "Something went wrong";
        }
        echo $msg;
    }
    return $connection;
}


function close_database_connection(&$connection)
{
    $connection = null;
}

// Driver={IBM i Access ODBC Driver};System=127.0.0.1;AlwaysCalculateResultLength=1;CCSID=1208

// connect
// try {
//     // NAM=1 means connect using system naming mode (enable library lists)
//     $conn = new PDO('odbc:DSN=*LOCAL;NAM=1;UID=myusr;PWD=mypass',null, null, array(
//         PDO::ATTR_PERSISTENT => false, // if no persistence
//         PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // show errors as exceptions
//     ));
// } catch (PDOException $exception) {
//     echo $exception->getMessage();
//     exit;
// } // (try connection)

// $sql = "select * from QCUSTCDT where city = ?";
// try {   
//     $query = $conn->prepare($sql);
// } catch (PDOException $exception) {
//     echo $exception->getMessage();
//     exit;
// } // (try prepare)

// $city = 'Dallas'; // city of your choice
// $query->bindParam(1, $city);

// $query->execute(); 

// $rows = $query->fetchAll();
// print_r($rows); 
