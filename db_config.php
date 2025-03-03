<?php
$servername = $_SERVER['RDS_HOSTNAME'];
$username = $_SERVER['RDS_USERNAME'];
$password = $_SERVER['RDS_PASSWORD'];
$database = $_SERVER['RDS_DB_NAME'];
$port = $_SERVER['RDS_PORT'];

function getConnection() {
    global $servername, $username, $password, $database, $port;
    $con = new mysqli($servername, $username, $password, $database, $port);
    if (mysqli_connect_errno()) {
        header("Location: database_error.php?error=connection");
    }
    return $con;
}
?>