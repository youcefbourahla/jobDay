<?php

session_start();


$DB_host = "localhost";

$DB_user = "root";

$DB_pass = "";

$DB_name = "utechdz_utechnolgie";

try
{
     $DB_con = new PDO("mysql:host={$DB_host};dbname={$DB_name}",$DB_user,$DB_pass);
     $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
     echo $e->getMessage();
}

$path = $_SERVER['DOCUMENT_ROOT']."/site/";
include_once $path.'amministrazione/services/UserService.class.php';
$userService = new UserService($DB_con);
