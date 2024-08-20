<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Content-type:application/json;charset=utf-8");
header("Access-Control-Allow-Methods: GET");
header('Content-Type: application/json');
$servername = "167.86.102.190";
$username = "futureadvisers_usstee";
$password = "@7##g-2T~+)l";
$dbname = "futureadvisers_sitedb";
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
