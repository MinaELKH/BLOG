<?php
header('Content-Type: application/json');
use  ModelsReservation\AfficheReservation ; 
use Models\DatabaseManager ;

// require_once __DIR__ . "/../backend/AfficheVehicule.php";
// require_once __DIR__ . '/../../includ/DatabaseManager.php';



// la liste des vehicule apres le filtrage


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //$inputSearch = $_POST['search'];
    $inputSearch = isset($_POST['search']) ? $_POST['search'] : '';
    // $inputModel = isset($_POST['model']) ? $_POST['model'] : '';
    // $inputMarque= isset($_POST['marque']) ? $_POST['marque'] : '';
    $inputCategorie = isset($_POST['categorie']) ? $_POST['categorie'] : '';
    $filters = [];
    if (!empty($inputSearch)) {
        $filters += [
            'nom'  => $inputSearch,
            'nom_categorie' => $inputSearch,
            'model'         => $inputSearch,
            'marque'        => $inputSearch
        ];
    }
    if (!empty($inputCategorie)) {
        $filters += ['nom_categorie' => $inputCategorie];
    }
    // if(!empty($inputMarque)){
    //     $filters +=['marque' => $inputMarque];
    // } 
    // if(!empty($inputModel)){
    //     $filters +=['model' => $inputModel];
    // } 

    $dbManager = new DatabaseManager();
    $newfilterVehicule = new AfficheVehicule($dbManager);
    $result = $newfilterVehicule->getFiltered($dbManager, $filters); // Assurez-vous que cette méthode existe dans `classe_Vehicule`.

    echo json_encode($result);
} else {
    echo json_encode([
        'message' => 'Aucune recherche reçue'
    ]);
}
