<?php

namespace Models;

use Models\DatabaseManager;
use stdClass;
use PDO;

class Comment
{
    private DatabaseManager $dbManager;
    private ?int $id_comment;
    private ?string $content;
    private ?int $id_article;
    private ?int $id_user;
    private ?string $archive;

    public function __construct(
        DatabaseManager $dbManager,
        ?int $id_comment = null,
        ?string $content = null,
        ?int $id_article = null,
        ?int $id_user = null,
        ?string $archive = '0'
    ) {
        $this->dbManager = $dbManager;
        $this->id_comment = $id_comment;
        $this->content = $content;
        $this->id_article = $id_article;
        $this->id_user = $id_user;
        $this->archive = $archive;
    }

    public function getAllByArticle($id_article): array
    {
        $params = ['id_article' => $id_article, 'archive' => '0'];
        return $this->dbManager->selectAll('comments', $params);
    }

    public function add(): bool
    {
        $data = [
            'content' => $this->content,
            'id_article' => $this->id_article,
            'id_user' => $this->id_user,
            'archive' => $this->archive,
        ];
        return $this->dbManager->insert('comments', $data);
    }

    public function delete(): bool
    {
        $query = "delete from comments
                   where id_comment= :id_comment  " ; 
        $db= $this->dbManager->getConnection();
        $stmt = $db->prepare($query) ; 
        $stmt->bindValue(":id_comment",$this->id_comment , PDO::PARAM_INT) ;                      
        // $displayQuery = str_replace(':id_comment', $this->id_comment, $query);
        // echo($displayQuery);
        // die();
        return     $stmt->execute(); 
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function getCommentByArticle()
    {
        $query = "select c.*  , nom , prenom from comments c
        inner join users  u on u.id_user = c.id_user
        where id_article = :id_article";
        $connection = $this->dbManager->getConnection();
        $stmt = $connection->prepare($query);
        $stmt->bindparam(":id_article", $this->id_article, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } else {
            return false;
        }
    }
}
