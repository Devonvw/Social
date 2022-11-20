<?php 
$loggedIn = false;
session_start(); 

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]) $loggedIn = true;
?>