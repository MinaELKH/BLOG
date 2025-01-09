

<?php 
// Il y a une relation qui lie l'utilisateur au client. C'est une relation d'héritage. Normalement, nous devons 
// créer une classe Client qui hérite de User (qui utlise la methode standard) , mais vu que nous avons travaillé avec DatabaseManager, 
// nous n'avons pas implémenté l'héritage.
    class Client  extends User{
       

        public function getAll(): array
       {   $params=[ 'archive'=>'0'  ]  ;
            return $this->dbManager->selectAll('users' , $params);
        }

        public function getById($id): ?stdClass
        {
            $params=['id_activite' => $id] ;
            return $this->dbManager->selectById('users', $params);
        }
        //changer Role
        public function EditerRoleClient(): bool
        {
            $data =  [
                'id_role' => $this->id_role 
                ] ;
            $condition=['id_user'=> $this->id_user] ;
            return $this->dbManager->Update('users', $data , $condition);
        }
        // archive 
        public function ArchiverClient(): bool
        {
            $data =  [
                'archive' => $this->archive
                ] ;
            $condition=['id_user'=> $this->id_user] ;
            return $this->dbManager->Update('users', $data , $condition);
        }

        public function setIdRole(int $id_role): void {
            $this->id_role = $id_role;
        }
        public function setArchive(int $archive): void {
            $this->archive = $archive;
        }

        public function supprimerClient(): bool
        {
            return $this->dbManager->delete('users', 'id_user',$this->id_user);
        }
    
 
}
