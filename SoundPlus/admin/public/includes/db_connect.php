<?php

$servername="localhost";
$username="root";
$password="";
$db="soundplus";

$conn=new mysqli($servername,$username,$password,$db);

if($conn->connect_error)
{
    die("Database is Not Connected".$conn->connect_error);
}
?>