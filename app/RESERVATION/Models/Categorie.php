<?php
namespace  Models ; 
use Models\Database ;
use Models\DatabaseManager ;
use stdClass ; 
class Categorie
{
    private DatabaseManager $dbManager;
    private ?int $id_categorie;
    private ?string $nom;
    private ?string $description;
    private ?string $archive;

    public function __construct(
        DatabaseManager $dbManager,
        ?int $id_categorie = null,
        ?string $nom = null,
        ?string $description = null,
        ?string $archive = '0'
    ) {
        $this->dbManager = $dbManager;
        $this->id_categorie = $id_categorie;
        $this->nom = $nom;
        $this->description = $description;
        $this->archive = $archive;
    }

    public function getAll(): array
    {
        $params = ['archive' => '0'];
        return $this->dbManager->selectAll('categorie', $params);
    }


    public function getById($id): ?stdClass
    {
        $params = ['id_categorie' => $id];
        $attributs = [] ;
        return $this->dbManager->selectAttributById('categorie',$attributs, $params);
    
    }

    public function ajouterCategorie(): bool
    {
        $data = [
            'id_categorie' => $this->id_categorie,
            'nom' => $this->nom,
            'description' => $this->description,
            'archive' => $this->archive
        ];
        return $this->dbManager->insert('categorie', $data);
    }


    public function EditerCategorie(): bool
    {
        $data = [
            'nom' => $this->nom,
            'description' => $this->description,
            'archive' => $this->archive
        ];
        $condition = ['id_categorie' => $this->id_categorie];
        return $this->dbManager->Update('categorie', $data, $condition);
    }

    // Supprimer une catégorie (soft delete via l'archivage)
    public function supprimerCategorie(): bool
    {
        $data = ['archive' => '1'];
        $condition = ['id_categorie' => $this->id_categorie];
        return $this->dbManager->Update('categorie', $data, $condition);
    }

    
}
