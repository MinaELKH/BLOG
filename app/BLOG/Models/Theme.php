<?php
namespace Models;

use Models\DatabaseManager;
use stdClass;

class Theme
{
    private DatabaseManager $dbManager;
    private ?int $id_theme;
    private ?string $name;
    private ?string $description;
    private ?string $archive;

    public function __construct(
        DatabaseManager $dbManager,
        ?int $id_theme = null,
        ?string $name = null,
        ?string $description = null,
        ?string $archive = '0'
    ) {
        $this->dbManager = $dbManager;
        $this->id_theme = $id_theme;
        $this->name = $name;
        $this->description = $description;
        $this->archive = $archive;
    }

    public function getAll(): array
    {
        $params = ['archive' => '0'];
        return $this->dbManager->selectAll('themes', $params);
    }

    public function getById($id): ?stdClass
    {
        $params = ['id_theme' => $id];
        $columns =[] ; 
        return $this->dbManager->selectAttributById('themes',$columns ,$params);
    }

    public static function getFiltered($dbManager, $filters, $limit_row = 10, $offset_row = 0)
    {
        $params = ['archive' => '0'];
        // Appel à la méthode de la base de données avec gestion des filtres et pagination
        return $dbManager->selectAllFilterLimit('listevehicule', $params, $filters, $limit_row, $offset_row);
    } 

    
    public function add(): bool
    {
        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'archive' => $this->archive,
        ];
        return $this->dbManager->insert('themes', $data);
    }

    public function update(): bool
    {
        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'archive' => $this->archive,
        ];
        $condition = ['id_theme' => $this->id_theme];
        return $this->dbManager->update('themes', $data, $condition);
    }

    public function delete(): bool
    {
        $data = ['archive' => '1'];
        $condition = ['id_theme' => $this->id_theme];
        return $this->dbManager->update('themes', $data, $condition);
    }
}
