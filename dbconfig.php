<?php

// The database connections will be needed for multiple files
// So it is always a good idea to have a common file to make the db connection
// and the include it in every php file where a db connection is needed.

// Look for the include('dbconfig'); line at the top of the php file 
// This is where the below code is imported using the include function. 

    
ini_set('date.timezone', 'UTC');

$host_name  = "localhost";
$user_name  = "root";
$password   = "scarysea";
// $password   = "mypass";
$database   = "qtalk";

global $con;
$con = mysqli_connect($host_name, $user_name, $password, $database);

$con->set_charset("utf8");
if(!$con)
{
  exit("Connection problem: ".mysql_connect_error());
}

?>