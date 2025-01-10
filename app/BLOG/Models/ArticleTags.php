<?php
namespace Models;

use Models\DatabaseManager;
use PDO ;
class ArticleTags
{
    private DatabaseManager $dbManager;
    private ?int $id_article;
    private ?int $id_tag;
    private ?string $archive;

    public function __construct(
        DatabaseManager $dbManager,
        ?int $id_article = null,
        ?int $id_tag = null,
        ?string $archive = '0'
    ) {
        $this->dbManager = $dbManager;
        $this->id_article = $id_article;
        $this->id_tag = $id_tag;
        $this->archive = $archive;
    }

    public function linkTagToArticle(): bool
    {
        $data = [
            'id_article' => $this->id_article,
            'id_tag' => $this->id_tag,
            'archive' => $this->archive,
        ];
        return $this->dbManager->insert('article_tags', $data);
    }


// &ffiche les tag dans l article
    public function getTagsByArticle(): array
    {
       $query = "select t.id_tag ,name from tags t 
                 inner join article_tags  a on a.id_tag = t.id_tag
                 where id_article = :id_article " ;
       $db = $this->dbManager->getConnection();
       $stmt=  $db->prepare($query);
       $stmt->bindParam(":id_article" , $this->id_article , PDO::PARAM_INT) ;
    //    var_dump($stmt->execute());
    //    die();
       if($stmt->execute()){
             return $stmt->fetchAll(PDO::FETCH_OBJ) ; 
       }else {

             return false ; 
       }
       
    }
}
