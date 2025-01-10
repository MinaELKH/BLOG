<?php
namespace Models;
use Models\DatabaseManager;
use stdClass;
use PDO ;
class Article
{
    private DatabaseManager $dbManager;
    private ?int $id_article;
    private ?string $title;
    private ?string $content;
    private ?int $id_user;
    private ?int $id_theme;
    private ?string $photo;
    private ?string $statut;
    private ?string $archive;
    private ?string $created_at ;

    public function __construct(
        DatabaseManager $dbManager,
        ?int $id_article = null,
        ?string $title = null,
        ?string $content = null,
        ?string $photo = null,
        ?int $id_theme = null,
        ?int $id_user = null,
        ?string $statut = 'en attente',
        ?string $archive = '0',
        ?string $created_at =null
    ) {
        $this->dbManager = $dbManager;
        $this->id_article = $id_article;
        $this->title = $title;
        $this->content = $content;
        $this->photo = $photo;
        $this->id_theme = $id_theme;
        $this->id_user = $id_user;
        $this->statut = $statut;
        $this->archive = $archive;
        $this->created_at =$created_at ;
    }

    public function getAll(): array
    {
        $params = ['archive' => '0'];
        return $this->dbManager->selectAll('articles', $params);
    }


    
    public function getArticleById(): ?array
    {
        $query = "select * from article
        where id_article = :id_article archive =  0 " ;
        $connection = $this->dbManager->getConnection();
        $stmt = $connection->prepare($query) ; 
        $stmt->bindValue(":id_article", $this->id_article, PDO::PARAM_INT);
         if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_OBJ);
        } else {
            return false;
        }
    }


    public function getArticleByIdTheme(): ?array
    {
        $query = "select * from detailArticle
        where id_theme = :id_theme and archive =  0 " ;
        $connection = $this->dbManager->getConnection();
        $stmt = $connection->prepare($query) ; 
        $stmt->bindValue(":id_theme", $this->id_theme, PDO::PARAM_STR);
         if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } else {
            return false;
        }
    }

    public function getArticleByIdUser(): ?array
    {
        $query = "select * from detailArticle
        where id_user = :id_user  and archive =  0 " ;
        $connection = $this->dbManager->getConnection();
        $stmt = $connection->prepare($query) ; 
        $stmt->bindValue(":id_user", $this->id_user, PDO::PARAM_INT);
         if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } else {
            return false;
        }
    }
    
    public function getDetailArticle(): ?stdClass 
    {
        $query= "select * from detailArticle
                  where id_article = :id_article
                  and archive =  0 " ;
        $db = $this->dbManager->getConnection()  ;
        $stmt = $db->prepare($query) ;
        $stmt->bindParam(":id_article" , $this->id_article , PDO::PARAM_INT) ; 
        if($stmt->execute()){
            return $stmt->fetch(PDO::FETCH_OBJ);
        } else {
            return false ; 
        }
    }


    public function getSearch($MotSearch):? array{
         $query = "SELECT DISTINCT viewArticle.*
         FROM detailArticle AS viewArticle
         INNER JOIN articles ar ON ar.id_article = viewArticle.id_article
         INNER JOIN themes th ON ar.id_theme = th.id_theme
         LEFT JOIN article_tags artg ON ar.id_article = artg.id_article
         LEFT JOIN tags tg ON artg.id_tag = tg.id_tag
         WHERE 
             ar.title LIKE :MotSearch OR 
             ar.content LIKE :MotSearch OR 
             tg.name LIKE :MotSearch OR 
             th.name LIKE :MotSearch and 
             archive =  0 
         LIMIT 10 OFFSET 0" ;

            $db = $this->dbManager->getConnection()  ;
            $stmt = $db->prepare($query) ;
            $stmt->bindValue(":MotSearch" , '%'.$MotSearch.'%' , PDO::PARAM_STR) ; 
            if($stmt->execute()){
                return $stmt->fetchALL(PDO::FETCH_OBJ);
            } else {
                return false ; 
            }
    }

    public function add(): bool
    {
        $data = [
            'title' => $this->title,
            'content' => $this->content,
            'id_user' => $this->id_user,
            'id_theme' => $this->id_theme,
            'statut' => $this->statut,
            'archive' => $this->archive,
        ];
        return $this->dbManager->insert('articles', $data);
    }

    public function update(): bool
    {
        $data = [
            'title' => $this->title,
            'content' => $this->content,
            'id_user' => $this->id_user,
            'id_theme' => $this->id_theme,
            'statut' => $this->statut,
            'archive' => $this->archive,
        ];
        $condition = ['id_article' => $this->id_article];
        return $this->dbManager->update('articles', $data, $condition);
    }

    public function delete(): bool
    {
        $data = ['archive' => '1'];
        $condition = ['id_article' => $this->id_article];
        return $this->dbManager->update('articles', $data, $condition);
    }


    public function __set($name , $value){

        return $this->$name = $value;

    }
    public function __get($name){

        return $this->$name ;

    }
}
