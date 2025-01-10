<?php
namespace Models;

use Models\DatabaseManager;
use stdClass;
use PDO ;
use PDOException; 
class Favorite
{
    private DatabaseManager $dbManager;
    private ?int $id_favorite;
    private ?int $id_user;
    private ?int $id_article;


    public function __construct(
        DatabaseManager $dbManager,
        ?int $id_favorite= null,
        ?int $id_article = null,
        ?int $id_user = null,
   
    ) {
        $this->dbManager = $dbManager;
        $this->id_favorite = $id_favorite;
        $this->id_user = $id_user;
        $this->id_article = $id_article;
   
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
        ];
       
        return $this->dbManager->insert('favorites', $data);
    }

    public function delete(): bool
    {
        $data = ['archive' => '1'];
        $condition = ['id' => $this->id_favorite];
        return $this->dbManager->update('favorites', $data, $condition);
    }

    public function userLikeArticle() {
        $query = "SELECT * FROM favorites WHERE id_user = :id_user AND id_article = :id_article";
        
        try {
            $connection = $this->dbManager->getConnection();
            $stmt = $connection->prepare($query);
            
            // Bind parameters securely
            $stmt->bindParam(":id_user", $this->id_user, PDO::PARAM_INT);
            $stmt->bindParam(":id_article", $this->id_article, PDO::PARAM_INT);
    
            // Execute the query
            $stmt->execute();
    
            // Fetch the result as an object
            return $stmt->fetch(PDO::FETCH_OBJ) ?: false;
        } catch (PDOException $e) {
            // Log or handle the exception as needed
            error_log("Error in userLikeArticle: " . $e->getMessage());
            return false;
        }
    }
    
}
