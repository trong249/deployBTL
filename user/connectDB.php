<?php 

$hostname = "mysql5037.site4now.net";
    $username = "a7cc8e_dapoet1";
    $password = "n24v9t2001";
    $database = "db_a7cc8e_dapoet1";

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    echo "Cannot connect to database: Error " . mysqli_connect_error();
    exit;
}


?>