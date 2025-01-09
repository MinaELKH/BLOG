<?php 
namespace  Models ; 
use Models\DatabaseManager;
    class User {
        protected DatabaseManager $dbManager;
        protected ?int $id_user;
        protected ?string $nom;
        protected ?string $prenom;
        protected ?string $email;
        protected ?float $pwd;
        protected ?string $telephone; 
        protected ?string $adresse;
        protected ?int $id_role;
        protected ?string $archive;
    
        public function __construct(DatabaseManager $dbManager, ?int $id_user, ?string $nom = '', ?string $prenom = '', ?string $email = '', ?float $pwd = null, ?string $telephone = '', ?string $adresse = '', ?int $id_role = null, ?string $archive = '0') {
            $this->dbManager = $dbManager;
            $this->id_user = $id_user;
            $this->nom = $nom;
            $this->prenom = $prenom;
            $this->email = $email;
            $this->pwd = $pwd;
            $this->telephone = $telephone; 
            $this->adresse = $adresse;
            $this->id_role = $id_role;
            $this->archive = $archive;
        }

}
