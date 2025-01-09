<?php 
namespace  Models ; 
use Models\Database ;
use Models\DatabaseManager ;

class Vehicule
{
    private DatabaseManager $dbManager;
    private ?int $id_vehicule;
    private ?string $nom;
    private ?string $model;
    private ?string $marque;
    private ?float $prix;
    private ?string $archive;
    public ?string $photo ; 
    public ?int $id_categorie ;

    public function __construct(
        DatabaseManager $dbManager,
        ?int $id_vehicule = 0,
        ?string $nom = null,
        ?string $marque = null,
        ?string $model = null,
        ?float $prix = 0,
        ?string $archive = '0',
        ?string $photo = null,
        ?int $id_categorie = null,
   
    ) {
        $this->dbManager = $dbManager;
        $this->id_vehicule = $id_vehicule;
        $this->nom = $nom;
        $this->model = $model;
        $this->marque = $marque;
        $this->prix = $prix;
        $this->archive = $archive;
        $this->photo = $photo;
        $this->id_categorie = $id_categorie;
 
    }
    public function getAll(): array
   {   $params=[ 'archive'=>'0'  ]  ;
        return $this->dbManager->selectAll('vehicule' , $params);
    }

    public function getById($id): ?stdClass
    {
        $params=['id_vehicule' => $id] ;
        $attributs = [] ;
        return $this->dbManager->selectAttributById('vehicule',$attributs, $params);
    }

    public function ajouterVehicule( ): bool
    {
        $data =  [
            'id_vehicule' => $this->id_vehicule,
            'nom' => $this->nom,
            'model' => $this->model,
            'marque' => $this->marque,
            'prix' => $this->prix,
            'archive' => $this->archive,
            'photo' => $this->photo,
            'id_categorie' => $this->id_categorie, 
        ] ;
        return $this->dbManager->insert('vehicule', $data);
    }

    public function EditerVehicule(): bool
    {
        $data =  [
            'id_vehicule' => $this->id_vehicule,
            'nom' => $this->nom,
            'model' => $this->model,
            'marque' => $this->marque,
            'prix' => $this->prix,
            'archive' => $this->archive,
            'photo' => $this->photo,
            'id_categorie' => $this->id_categorie,
        ] ;
        $condition=['id_vehicule'=> $this->id_vehicule] ;
        return $this->dbManager->Update('vehicule', $data , $condition);
    }
    public function supprimerVehicule(): bool
    {
        return $this->dbManager->delete('vehicule', 'id_vehicule',$this->id_vehicule);
    }
    public function getAttributById(array $attributs = []): ?stdClass // il prend en param un array des colonne a affichées
    {
        $params = ['id_vehicule' => $this->id_vehicule];
        return $this->dbManager->selectAttributById('vehicule',$attributs , $params );
    }
}
