<?php

namespace  Models;

use Models\Database;
use Models\DatabaseManager;
use stdClass;

class AfficheReservation
{
    private DatabaseManager $dbManager;
    public function __construct(
        DatabaseManager $dbManager,
    ) {
        $this->dbManager = $dbManager;
    }

    // Récupérer toutes les réservations
    public function getAllReserv_Of_User($id_user): array
    {
        $params = [
            'archive' => '0',
            'id_user' => 13
        ];
        return $this->dbManager->selectAll('listeresevation', $params);
    }

    // Récupérer une réservation par ID
    public function getById($id): ?stdClass
    {
        $params = ['id_reservation' => $id];
        return $this->dbManager->selectById('listeresevation', $params);
    }
    // Récupere les données depuis la DB en mettant ds l objet
    public static function fromDatabase(object $data, DatabaseManager $dbManager): self
    {
        return new self(
            $dbManager,
            $data->id_avis ?? null,
            $data->id_reservation ?? null,
            $data->description ?? null,
            $data->etoiles ?? null,
            $data->id_vehicule ?? null,
            $data->id_user ?? null,
            $data->id_agence ?? null,
            $data->date_reservation ?? null,
            $data->date_debut ?? null,
            $data->date_fin ?? null,
            $data->prix ?? null,
            $data->statut ?? null,
            $data->archive ?? null,
            $data->nom_user ?? null,
            $data->nom_categorie ?? null,
            $data->nom_vehicule ?? null,
            $data->marque ?? null,
            $data->model ?? null,
            $data->photo ?? null,
            $data->date_avis ?? null
        );
    }
}
