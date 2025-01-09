<?php   //index.php 
require_once __DIR__ . '/autoload.php';

       use Models\DatabaseManager;
       use Models\Database;
       
       // Créer des instances des classes
       $manager = new DatabaseManager();
       $manager->affiche();
       
       $db = new Database();
       $db->affiche() ; 





        //header("location: app/frontend/home.php") ;
?>
