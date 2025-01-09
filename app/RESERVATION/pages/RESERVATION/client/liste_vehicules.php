<?php
header('Content-Type: application/json');

use  ModelsReservation\AfficheVehicule ; 
use Models\DatabaseManager ;

// require_once __DIR__ . "/../backend/classe_AfficheVehicule.php";
// require_once __DIR__ . '/../../includ/DatabaseManager.php';


// liste des vehicule sans filtrage
if ($_SERVER["REQUEST_METHOD"] == "GET") {
   
    $dbManager = new DatabaseManager();
    $newfilterVehicule = new AfficheVehicule($dbManager);
    $limit = 12  ; 
    $offset = 0 ; 
    $result = $newfilterVehicule->getAll($dbManager , $limit , $offset); // Assurez-vous que cette méthode existe dans `classe_Vehicule`.

    echo json_encode($result);
} else {
    echo json_encode([
        'message' => 'Aucune resultat reçue'
    ]);
}



