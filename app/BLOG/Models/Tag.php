<?php
namespace Models;

use Models\DatabaseManager;
use stdClass;

class Tag
{
    private DatabaseManager $dbManager;
    private ?int $id_tag;
    private ?string $name;
    private ?string $archive;

    public function __construct(
        DatabaseManager $dbManager,
        ?int $id_tag = null,
        ?string $name = null,
        ?string $archive = '0'
    ) {
        $this->dbManager = $dbManager;
        $this->id_tag = $id_tag;
        $this->name = $name;
        $this->archive = $archive;
    }

    public function getAll(): array
    {
        $params = ['archive' => '0'];
        return $this->dbManager->selectAll('tags', $params);
    }

    public function getById($id): ?stdClass
    {
        $params = ['id_tag' => $id];
        return $this->dbManager->selectById('tags', $params);
    }

    public function add(): bool
    {
        $data = [
            'name' => $this->name,
            'archive' => $this->archive,
        ];
        return $this->dbManager->insert('tags', $data);
    }

    public function update(): bool
    {
        $data = ['name' => $this->name, 'archive' => $this->archive];
        $condition = ['id_tag' => $this->id_tag];
        return $this->dbManager->update('tags', $data, $condition);
    }

    public function delete(): bool
    {
        $data = ['archive' => '1'];
        $condition = ['id_tag' => $this->id_tag];
        return $this->dbManager->update('tags', $data, $condition);
    }
}
