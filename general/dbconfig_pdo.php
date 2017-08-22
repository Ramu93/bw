<?php
$host = "localhost";
$user = "shreefas_bondusr";
$pass = "TMTbond123$";
$name = "shreefas_bonded";

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
