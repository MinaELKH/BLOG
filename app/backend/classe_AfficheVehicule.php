<?php

class AfficheVehicule
{
    private DatabaseManager $dbManager;
    public function __construct(
        DatabaseManager $dbManager,
    ) {
        $this->dbManager = $dbManager ; 
    }
    public static  function getAll( $dbManager, int $limit_row ,int $offset_row ): array   //$offset on commence par row 
    { // affiche getAll(12,10 )  : affiche 12 vehicule en commence de row 10+1
        $params = ['archive' => '0' ];
        $filters = [];
        return $dbManager->selectAllFilterLimit('listevehicule', $params ,$filters ,$limit_row , $offset_row);
     }

    // Récupérer une réservation par ID
    public static function getById($dbManager,$id): ?stdClass
    {
        $params = ['id_vehicule' => $id];
        return $dbManager->selectById('listevehicule', $params);
    }
    public static function getFiltered($dbManager, $filters, $limit_row = 10, $offset_row = 0)
    {
        $params = ['archive' => '0'];

        // Appel à la méthode de la base de données avec gestion des filtres et pagination
        return $dbManager->selectAllFilterLimit('listevehicule', $params, $filters, $limit_row, $offset_row);
    }
}
