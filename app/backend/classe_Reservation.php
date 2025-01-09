<?php
enum Statut: string
{
    case enAttente = 'en attente';
    case confirmee = 'confirmée';
    case annulee = 'annulée';
}

class Reservation
{
    private DatabaseManager $dbManager;
    private ?int $id_reservation;
    private ?int $id_vehicule;
    private ?int $id_user;
    private ?int $id_agence;
    private ?string $date_reservation;
    private ?string $date_debut;
    private ?string $date_fin;
    private ?Statut $statut;
    private ?int $archive;

    public function __construct(
        DatabaseManager $dbManager,
        ?int $id_reservation = null,
        ?int $id_vehicule = null,
        ?int $id_user = null,
        ?int $id_agence = null,
        ?string $date_reservation = null,
        ?string $date_debut = null,
        ?string $date_fin = null,
        ?Statut $statut = null ,
        ?int $archive = 0
    ) {
        $this->dbManager = $dbManager;
        $this->id_reservation = $id_reservation;
        $this->id_vehicule = $id_vehicule;
        $this->id_user = $id_user;
        $this->id_agence = $id_agence;
        $this->date_reservation = $date_reservation;
        $this->date_debut = $date_debut;
        $this->date_fin = $date_fin;
        $this->statut = $statut;
        $this->archive = $archive;
    }

    // Récupérer toutes les réservations
    public function getAll(): array
    {
        $params = ['archive' => '0'];
        return $this->dbManager->selectAll('reservation', $params);
    }

    // Récupérer une réservation par ID
    public function getById($id): ?stdClass
    {
        $column=[] ; 
        $params = ['id_reservation' => $id];

        return $this->dbManager->selectAttributById('reservation',$column, $params);
    }

    // Ajouter une nouvelle réservation
    public function ajouterReservation(): bool
    {
        $data = [
            'id_vehicule' => $this->id_vehicule,
            'id_user' => $this->id_user,
            'id_agence' => $this->id_agence,
            'date_reservation' => $this->date_reservation,
            'date_debut' => $this->date_debut,
            'date_fin' => $this->date_fin,
            'statut' => $this->statut , 
            'archive' => $this->archive
        ];
        return $this->dbManager->insert('reservation', $data);
    }

    // Modifier une réservation
    public function EditerReservation(): bool
    {
        $data = [
            'id_vehicule' => $this->id_vehicule,
            'id_user' => $this->id_user,
            'id_agence' => $this->id_agence,
            'date_reservation' => $this->date_reservation,
            'date_debut' => $this->date_debut,
            'date_fin' => $this->date_fin,
            'statut' => $this->statut
        ];
        $condition = ['id_reservation' => $this->id_reservation];
        return $this->dbManager->update('reservation', $data, $condition);
    }

    // Supprimer une réservation (Soft Delete : changer le statut à 'annulée')
    public function archiveReservation(): bool
    {
        $data = ['archive' => '1'];
        $condition = ['id_reservation' => $this->id_reservation];
        return $this->dbManager->update('reservation', $data, $condition);
    }

    public function changeStatut($newStatut): bool
    {
        $data = ['statut' => $newStatut];
        $condition = ['id_reservation' => $this->id_reservation];
        return $this->dbManager->update('reservation', $data, $condition);
    }


    public function getAttributById(array $attributs = []): ?stdClass// il prend en param un array des colonne a affichées
    {
        $params = ['id_reservation' => $this->id_reservation];
        return $this->dbManager->selectAttributById('reservation',$attributs , $params );
    }


    public function disponibilite($date_debut, $date_fin) {
       
        require_once __DIR__ . '/../../includ/db.php';
        $db = Database::getInstance();
        $connection = $db->getConnection();
    
        $id_vehicule = $this->id_vehicule;
    
    
        $query = "
            SELECT 
            (SELECT COUNT(*) 
             FROM reservation 
             WHERE :date_debut BETWEEN date_debut AND date_fin 
               AND id_vehicule = :id_vehicule)
            +
            (SELECT COUNT(*) 
             FROM reservation 
             WHERE :date_fin BETWEEN date_debut AND date_fin 
               AND id_vehicule = :id_vehicule) 
            AS total;
        ";
    
        $stmt = $connection->prepare($query);

        $stmt->bindValue(':date_debut', $date_debut, PDO::PARAM_STR);
        $stmt->bindValue(':date_fin', $date_fin, PDO::PARAM_STR);
        $stmt->bindValue(':id_vehicule', $id_vehicule, PDO::PARAM_INT);
        
        $stmt->execute();
    
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($result && isset($result['total'])) {
            return $result['total']; 
        }
    
   
        return 0;
    }


    public function disponibiliteWithProcedureSQL($date_debut, $date_fin) {  
        require_once __DIR__ . '/../../includ/db.php';
        $db = Database::getInstance();
        $connection = $db->getConnection();
    
        // Définir la variable utilisateur @v_etat_request
        $connection->query("SET @v_etat_request = NULL;");
    
        // Requête pour appeler la procédure
        $query = "CALL AjouterReservation(
            :id_vehicule,
            :id_user,
            :date_reservation,
            :date_debut,
            :date_fin,
            :statut,
            @v_etat_request
        );";
    
        $id_vehicule = $this->id_vehicule;
        $id_user = $this->id_user;
        $date_reservation = date("Y-m-d H:i:s");
        $statut = 'en attente';
    
        $stmt = $connection->prepare($query);
        $stmt->bindValue(':id_vehicule', $id_vehicule, PDO::PARAM_INT);
        $stmt->bindValue(':id_user', $id_user, PDO::PARAM_INT);
        $stmt->bindValue(':date_reservation', $date_reservation, PDO::PARAM_STR);
        $stmt->bindValue(':date_debut', $date_debut, PDO::PARAM_STR);
        $stmt->bindValue(':date_fin', $date_fin, PDO::PARAM_STR);     
        $stmt->bindValue(':statut', $statut, PDO::PARAM_STR);
    
        try {
            $result = $stmt->execute(); // Exécution de la procédure stockée
    
            if ($result) {
                // Récupérer la valeur de @v_etat_request
                $statusQuery = "SELECT @v_etat_request AS reponse_disponiblite;";
                $statusStmt = $connection->query($statusQuery);
                $res_disponiblite = $statusStmt->fetch(PDO::FETCH_ASSOC);
              
                if ($res_disponiblite) {
                //    echo "État de disponibilité : " . $res_disponiblite['reponse_disponiblite'];
                    return $res_disponiblite['reponse_disponiblite'];
                }
            }
        } catch (PDOException $e) {
            echo "Erreur lors de l'exécution de la procédure : " . $e->getMessage();
            return false;
        }
    }
      
}


// require_once __DIR__ . '/../../includ/DatabaseManager.php';

// $dbManager = new DatabaseManager();
// $reservation = new Reservation($dbManager, 0 , 3 , 15);


// $result = $reservation->disponibiliteWithProcedureSQL("2025-05-15", "2025-05-20");

// if ($result) {
//     echo "Résultat : " . $result;
// } else {
//     echo "Erreur ou véhicule non disponible.";
// }