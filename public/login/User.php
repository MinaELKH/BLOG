<?php 
require_once __DIR__ . '/../../includ/DB.php';
class User
{
    private int $id_user;
    private string $nom;
    private string $prenom;
    private string $email;
    private string $pwd;
    private string $telephone;
    private string $adresse;
    private int $id_role;
    private int $archive;


    private $db;

    public function __construct($nom,$prenom, $email, $pwd, $id_role ,$archive = 0
    ) {
        $this->db = Database::getInstance()->getConnection();
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->pwd = $pwd;
        $this->id_role = $id_role;
        $this->archive = $archive;
    }
    public function __toString()
    {
        return "Nom: {$this->nom}, Prénom: {$this->prenom}, Email: {$this->email}, Téléphone: {$this->telephone}, Adresse: {$this->adresse}, Rôle: {$this->id_role}, Archive: {$this->archive}";
    }
 
    public static function  login($email, $password)
    {
        try {
           
            $newdb = Database::getInstance();
            $db=$newdb->getConnection() ;
            $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_OBJ);  // recupere le reusltat sous forme d objet en revanche ; il recupere sous format array assoc $user = $stmt->fetch(PDO::FETCH_ASSOC);  
                if (password_verify($password, $user->pwd)) {      
                    return [
                        'success' => true,
                        'user' => $user
                    ];
                } else {
                    //  le mot de passe ne correspond pas
                    return [
                        'success' => false,
                        'message' => 'Mot de passe incorrect.'
                    ];
                }
            } else {
        
                return [
                    'success' => false,
                    'message' => 'Aucun utilisateur trouvé avec cet email.'
                ];
            }
        } catch (PDOException $e) {
   
            return [
                'success' => false,
                'message' => 'Erreur de connexion à la base de données: ' . $e->getMessage()
            ];
        }
    }


    // methode static pour enregistrer un nouvel utilisateur
    static public function registreUser($newUser)
    {
        try {
        
            $strm = $newUser->db->prepare('
                INSERT INTO users (nom, prenom, email, pwd, id_role, archive) 
                VALUES (:nom, :prenom, :email, :pwd,  :id_role, :archive)
            ');
            $strm->bindParam(':nom', $newUser->nom);
            $strm->bindParam(':prenom', $newUser->prenom);
            $strm->bindParam(':email', $newUser->email);
            $strm->bindParam(':pwd', $newUser->pwd);
            $strm->bindParam(':id_role', $newUser->id_role);
            $strm->bindParam(':archive', $newUser->archive);

        
            if ($strm->execute()) {
          
                return true; 
            } else {
                return false; 
            }
        } catch (PDOException $e) {
          //  echo "Erreur lors de l'insertion : " . $e->getMessage();
            return false;
        }
    }

    public function deconnecter(){
        session_start();
        session_destroy();
        header('Location: ../index.php');
    }

    public function lastInsertId() {
        // echo "<script> alert('Last inserted ID:" . $this->db->lastInsertId() ."' )</script>";
        // var_dump($this->db->lastInsertId());
        // exit; 
        return $this->db->lastInsertId();
    }
}




