<?php
$host = "localhost";
$user = "root";
$pass = "root";
$name = "bonded_warehouse";

try
{
	$dbobj = new PDO("mysql:host={$host};dbname={$name}",$user,$pass);
	$dbobj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
	echo $e->getMessage();
}
?>
