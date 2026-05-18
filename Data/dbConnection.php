<?php
$server = "localhost";
$username = "root";
$password = "";
$port = 3306;
$database = "newecommerce";
$conn = mysqli_connect($server,$username,$password,$database,port:$port);
if(!$conn){
    die("connection failed");
}
?>