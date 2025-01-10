<?php

namespace Models;

use stdClass;
use PDO ;
class Statistics
{
    private $dbManager;

    public function __construct(DatabaseManager $dbManager)
    {
        $this->dbManager = $dbManager;
    }

    /**
     * Retourne le nombre total d'articles.
     */
    public function getTotalArticles(): int
    {
        $query = "SELECT COUNT(*) AS total FROM articles";
        $stmt = $this->dbManager->getConnection()->query($query);
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }

    /**
     * Retourne le nombre d'articles non confirmés.
     */
    public function getUnconfirmedArticles(): int
    {
        $query = "SELECT COUNT(*) AS total FROM articles WHERE statut = 'en attente'";
        $stmt = $this->dbManager->getConnection()->query($query);
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }

    /**
     * Retourne le nombre total de thèmes.
     */
    public function getTotalThemes(): int
    {
        $query = "SELECT COUNT(*) AS total FROM themes";
        $stmt = $this->dbManager->getConnection()->query($query);
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }

      /**
     * Retourne le nombre total de thèmes.
     */
    public function getBestArticle(): stdClass  
    {
        $query = "SELECT COUNT(a.id_article) AS total  , title FROM articles a inner join comments c ON  a.id_article= c.id_article
                    group by title
                    ORDER BY title asc
                    LIMIT 1 
                    ";
        $stmt = $this->dbManager->getConnection()->query($query);
        $result = $stmt->fetch(PDO::FETCH_OBJ);;
        return $result ;
    }

    /**
     * Retourne des statistiques globales sous forme de tableau.
     */
    public function getGlobalStatistics(): array
    {
        return [
            'totalArticles' => $this->getTotalArticles(),
            'unconfirmedArticles' => $this->getUnconfirmedArticles(),
            'totalThemes' => $this->getTotalThemes(),
            'bestArticle' =>$this->getBestArticle(),
          
        ];
    }
}
