<?php

require_once __DIR__ . "/../backend/classe_AfficheVehicule.php";
require_once __DIR__ . '/../../includ/DatabaseManager.php';

$dbManager = new DatabaseManager();
$newListVehicule = new AfficheVehicule($dbManager);
$result = $newfilterVehicule ->getAll($dbManager);
//limit de sql ; combien de row a affiche
$limit = 10 ; 
//offset de sql ; commence par +1 (nb de row sauter)
$offset = 0  ;
echo json_encode($result ,$limit , $offset);
