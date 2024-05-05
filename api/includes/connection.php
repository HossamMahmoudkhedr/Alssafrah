<?php
$host="localhost";//database host
$name="Alssafarah";//database name
$user_name="root";//database username
$password="";//database password
$con=mysqli_connect($host,$user_name,$password,$name);//make the mysql connection

if (!$con) {//check the connection
    die("Connection failed: " . mysqli_connect_error());
}
