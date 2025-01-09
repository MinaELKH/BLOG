<?php
require_once(__DIR__ . '/../../includ/DB.php');
require_once(__DIR__ . '/../../includ/DataManager.php');
enum Statut: string
    {
        case enAttente = 'En attente';
        case confirmee = 'Confirmée';
        case annulee = 'Annulée';
    }


class Reservation 
{
 
    private int $id_reservation;
    private int $id_user;
    private ?int $id_vehicule;
    private ?Statut $statut;
    private ?string $date_reservation;
    private ?string $archive;
    private  DatabaseManager $db ;

    public function __construct( DatabaseManager $db , ?int $id_reservation=0, ?int $id_user =0 , ?int $id_vehicule =0 , ?Statut $statut = null, ?string $date_reservation ='', ?string $date_debut ='' , ?string $date_fin='' , ?string $archive = '0')
    {
        $this->id_reservation = $id_reservation;
        $this->id_user = $id_user;
        $this->id_vehicule = $id_vehicule;
        $this->statut = $statut ?? statut::enAttente;
        $this->date_reservation = $date_reservation ?: date('Y-m-d H:i:s');
        $this->date_debut= $date_debut ;
        $this->date_fin= $date_fin;
        $this->archive = $archive;
        $this->$db = $db  ; 
    }
    static public function affichertt(){
        $param = ['archive' => '0' ] ;
       return  $this->$db->selectAll('reservation' , $params) ; 
       
    }
    static public function createReservation($newRes){
         $this->db->insert('reservation');
        return  $result ;
    }
    public function changeActivite($id_reservation,$newActivite){
        $query = "update reservation
                  set id_vehicule = :newActivite
                  where id_reservation = :id_reservation";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_reservation',$id_reservation,PDO::PARAM_INT);
        $stmt->bindParam(':newActivite',$newActivite,PDO::PARAM_STR);
        $stmt->execute();
    }
    public function changeStatut($id_reservation, $newStatut){
   
    }
    
    public function archiveRes($id_reservation) {
        $query = "UPDATE reservation 
                  SET archive = '1' 
                  WHERE id_reservation = :id_reservation";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_reservation', $id_reservation, PDO::PARAM_INT);
        $stmt->execute();
    }

}