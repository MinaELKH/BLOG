<?php

namespace Models;
use Models\Database;;
use PDO ; 
 //require_once 'DB.php';
 
class DatabaseManager
{
    private PDO $connection;
    public function __construct()
    {
        // Obtenir l'instance unique de Database
        $db = Database::getInstance();
        // Utiliser la connexion PDO à partir de cette instance
        $this->connection = $db->getConnection();
    }
    public function getConnection()
    {
        return $this->connection;
    }
    // Méthode d'insertion générique
    public function insert(string $table, array $data): bool
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));  //array_fill() : Remplit un tableau avec des valeurs.
        $query = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $this->connection->prepare($query);
        return $stmt->execute(array_values($data));
    }

    // Méthode de suppression générique
    public function delete(string $table, string $condition, int $param): bool
    {
        $query = "DELETE FROM $table WHERE $condition =:valeur";
        
        $stmt = $this->connection->prepare($query);
       // $stmt->bindValue(":$param", $condition, PDO::PARAM_STR);

        $stmt->bindValue(":valeur" , $param , PDO::PARAM_INT ) ;

        return $stmt->execute();
    }


    public function update(string $table, array $data, array $condition): bool
{     // j ai un table associative key=> values   je dois recupere les cles de array $data
    //pour les mettre dans set je les ai convertis en chaine de caractere 
    // etape2 : je  recupere les values $data pour l execute dans stmt dans dernire ligne

    $columns =array_keys($data);
    $values = array_values($data);
    
     $set =implode(" =? ," , $columns) ; // converti array to string regarde l exemple de w3s sur insert 
     $set = $set ."=? " ;   
    $cond =array_key_first($condition);

    $query = "UPDATE $table SET $set WHERE  $cond=?";  // j ai utlisier array_key_first($array) pour avoir id_primaire_table que j ai passe en param, vue qu j ai qu une seuele valeur j ai trouvé cette methode pour recupere une seule key et (pas valeur !!!)
     array_push($values , $condition[$cond]);
   //  print_r($values) ;
    $stmt = $this->connection->prepare($query);
    if ($stmt->execute($values)){
         //  echo 'modif ok' ;
            return true ;
    } else {
        echo 'modif non' ;
    }
    
    return $stmt->execute($values);
}  


 public function selectAll(string $table, array $params = [] ): array
{
    $query = "SELECT * FROM $table";
    if (!empty($params)) {
        $conditions = [];
        foreach ($params as $param => $condition) {   
            $conditions[] = "$param = :$param";  
        }
        $cond =  implode(' AND ', $conditions);
        $query .= " WHERE " . $cond  ; 
    }
 
    $stmt = $this->connection->prepare($query);
    if (!empty($params)) {
        foreach ($params as $param => $condition) {
            $stmt->bindValue(":$param", $condition, PDO::PARAM_STR);
        }
    }
   if ($stmt->execute()){
      return $stmt->fetchAll(PDO::FETCH_OBJ);
   } else {
      return false ; 
   }
}

public function selectAllFilterLimit(string $table, array $params = [], array $filters = [], int $limit_row = 0, int $offset_row = 0): array
{
    $query = "SELECT * FROM $table";
    $conditions = [];
    
    // Ajout des conditions basées sur $params
    if (!empty($params)) {
        foreach ($params as $param => $value) {
            $conditions[] = "$param = :$param";
        }
    }

    // Ajout des conditions basées sur $filters
    if (!empty($filters)) {
        $conditions_filter = [];
        foreach ($filters as $filter => $value) {
            $conditions_filter[] = "$filter LIKE :$filter";
        }
        // Les filtres sont liés par "OR" et ajoutés au tableau des conditions
        $conditions[] = '(' . implode(' OR ', $conditions_filter) . ')';
    }

    // Ajout de la clause WHERE si des conditions existent
    if (!empty($conditions)) {
        $query .= " WHERE " . implode(' AND ', $conditions);
    }

    // Ajout des clauses LIMIT et OFFSET
    if ($limit_row > 0) {
        $query .= " LIMIT :limit_row";
    }
    if ($offset_row > 0) {
        $query .= " OFFSET :offset_row";
    }

    $stmt = $this->connection->prepare($query);

    // Liaison des valeurs des paramètres
    if (!empty($params)) {
        foreach ($params as $param => $value) {
            $stmt->bindValue(":$param", $value, PDO::PARAM_STR);
        }
    }

    // Liaison des valeurs des filtres
    if (!empty($filters)) {
        foreach ($filters as $filter => $value) {
            $stmt->bindValue(":$filter", '%' . $value .'%', PDO::PARAM_STR);
        }
    }

    // Liaison des valeurs pour LIMIT et OFFSET
    if ($limit_row > 0) {
        $stmt->bindValue(":limit_row", $limit_row, PDO::PARAM_INT);
    }
    if ($offset_row > 0) {
        $stmt->bindValue(":offset_row", $offset_row, PDO::PARAM_INT);
    }

    // Exécution et récupération des résultats
    if ($stmt->execute()) {
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    } else {
        return [];
    }
}

// select attribut1 , attribut2 .... from ...
public function selectAttributById(string $table,array $attributs = [] ,  array $params = []) : ?stdClass
{
    if (!empty($attributs)) {
            $column=  implode(' , ', $attributs);
            $query = "SELECT $column FROM $table";
    }
    else {
             $query = "SELECT * FROM $table";
    }
    if (!empty($params)) {
        $conditions = [];
        foreach ($params as $param => $condition) {  
            $conditions[] = "$param = :$param";  
            $query .= " WHERE " . implode(' AND ', $conditions);
       }
    }
    $stmt = $this->connection->prepare($query);
    if (!empty($params)) {
        foreach ($params as $param => $condition) {
            $stmt->bindValue(":$param", $condition, PDO::PARAM_STR);
        }
    }
   if ($stmt->execute()){
    $result = $stmt->fetch(PDO::FETCH_OBJ); 
    // var_dump($result);
    // exit ; 
        return $result;
   } else {
      return false ; 
   }

   
}


// c est pas data manager mais il faut gere ce cas ou il y un fetchALL. C ESt meme focntion que  selectAttributById
//mais cette fois il renvoit plusieur resultat 
public function selectAvis(string $table,array $attributs = [] ,  array $params = []) : ?array
{
    if (!empty($attributs)) {
            $column=  implode(' , ', $attributs);
            $query = "SELECT $column FROM $table";
    }
    else {
             $query = "SELECT * FROM $table";
    }
    if (!empty($params)) {
        $conditions = [];
        foreach ($params as $param => $condition) {  
            $conditions[] = "$param = :$param";  
            $query .= " WHERE " . implode(' AND ', $conditions);
       }
    }
    $stmt = $this->connection->prepare($query);
    if (!empty($params)) {
        foreach ($params as $param => $condition) {
            $stmt->bindValue(":$param", $condition, PDO::PARAM_STR);
        }
    }
   if ($stmt->execute()){
    $result = $stmt->fetchAll(PDO::FETCH_OBJ); 
    // var_dump($result);
    // exit ; 
        return $result;
   } else {
      return false ; 
   }

   
}






public function getLastInsertId(): int
{
    return (int)$this->connection->lastInsertId();
}



}
