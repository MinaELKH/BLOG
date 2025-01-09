<?php
//include 'db.php';
ob_start(); 
session_start() ;
    if($_SESSION['id_role'] !=1  ){ //client
      header("location: erreur.php") ;
      exit ;
    }
    else if($_SESSION['id_role'] ==1 ){ //admin et super admin 
       $id_user = $_SESSION['id_user'] ; 
    } 

$title = "DASHBORD";



$content = ob_get_clean(); 
include 'layout.php'; 
?>
