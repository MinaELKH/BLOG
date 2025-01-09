<?php
use Models\AfficheVehicule;
use Models\DatabaseManager;

$dbManager = new DatabaseManager();
$newfilterVehicule = new AfficheVehicule($dbManager);

$inputSearch = isset($_POST['search']) ? trim($_POST['search']): '';

// var_dump($inputSearch);
// exit;
$inputModel = isset($_POST['model']) ? $_POST['model'] : '';
$inputMarque= isset($_POST['marque']) ? $_POST['marque'] : '';
$inputCategorie = isset($_POST['categorie']) ? $_POST['categorie'] : '';

     $filters = [
        'nom'  => $inputSearch,
        'nom_categorie' => $inputSearch,
        'model'         => $inputSearch,
        'marque'        => $inputSearch , 
        'nom_categorie' => $inputCategorie ,
        'model'         => $inputModel,
        'marque'        => $inputMarque

    ];
$result = $newfilterVehicule ->getFiltered($dbManager , $filters);


echo json_encode($result);
