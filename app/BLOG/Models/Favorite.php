<?php
namespace Models;

use Models\DatabaseManager;
use stdClass;

class Favorite
{
    private DatabaseManager $dbManager;
    private ?int $id;
    private ?int $id_user;
    private ?int $id_article;
    private ?string $archive;

    public function __construct(
        DatabaseManager $dbManager,
        ?int $id = null,
        ?int $id_article = null,
        ?int $id_user = null,
        ?string $archive = '0'
    ) {
        $this->dbManager = $dbManager;
        $this->id = $id;
        $this->id_user = $id_user;
        $this->id_article = $id_article;
        $this->archive = $archive;
    }

    public function getAllByUser($id_user): array
    {
        $params = ['id_user' => $id_user, 'archive' => '0'];
        return $this->dbManager->selectAll('favorites', $params);
    }

    public function add(): bool
    {
        $data = [
            'id_user' => $this->id_user,
            'id_article' => $this->id_article,
            'archive' => $this->archive,
        ];
        return $this->dbManager->insert('favorites', $data);
    }

    public function delete(): bool
    {
        $data = ['archive' => '1'];
        $condition = ['id' => $this->id];
        return $this->dbManager->update('favorites', $data, $condition);
    }
}
