<?php
ob_start(); 
session_start() ;

session_start() ;
    if($_SESSION['id_role'] !=1 && $_SESSION['id_role'] !=2 ){ //client
      header("location: erreur.php") ;
      exit ;
    }
    else if($_SESSION['id_role'] ==1   ){ //admin et super admin 
       $id_user = $_SESSION['id'] ; 
    } 


$title = "Gestion des Clients";
require "../backend/classe_Client.php";
require_once __DIR__ . '/../../includ/DB.php';
require_once __DIR__ . '/../../includ/DatabaseManager.php';
$dbManager = new DatabaseManager();
$objClient = new Client($dbManager , 0);


if(isset($_POST["editRole"]) ){
    $id=  intval($_POST["id_user"]) ; 
    $newClient = new Client($dbManager , $id );
   
    $newClient->setIdRole($_POST['editRole'])  ;
    // print_r(  $newClient) ; 
    $objClient  = $newClient->EditerRoleClient() ;
    var_dump(   $objClient) ;

    if ($objClient) { 
        header("Location: Client.php");
        exit; 
    } else {
        echo "<p>Erreur : Remplissage de formulaire  </p>";
    }
}

if(isset($_POST["archive"]) ){
    $id=  intval($_POST["id_user"]) ; 
    $newClient = new Client($dbManager , $id );
    $newClient->setArchive(1)  ;//archive
    $objClient  = $newClient->ArchiverClient() ;


    if ($objClient) { 
        header("Location: Client.php");
        exit; 
    } else {
        echo "<p>Erreur : Remplissage de formulaire  </p>";
    }


}


if (isset($_POST["delete"])) {
    $id = intval($_POST["id_user"]); // S'assurer que l'ID est un entier
    echo "id : ".$id;
           $dbManager = new DatabaseManager();
           $newClient = new client($dbManager , $id);
            $result= $newClient->supprimerClient();
            if ($result) { 
                header("Location: activite.php");
                exit; 
            } else {
                echo "<p>Erreur : delete </p>";
            }
        }
?>
 

<?php
affiche() ; 
function affiche(){
    $dbManager = new DatabaseManager();
    $newClient = new Client($dbManager , 0);
    $result = $newClient->getAll();  // Assurez-vous que la méthode AfficheAllActivite() existe et fonctionne correctement
   // print_r($result);
    if ($result) {
    echo " <div class='listeTable' ><table border='1'><thead>";
    echo "<tr><th>ID</th><th>Nom</th><th>Email</th><th>Telephne</th><th>Adresse</th><th>Date_naissance</th><th>Action</th></tr></thead><tbody>";
    foreach ($result as $objet){
        $id= $objet->id_user; 
        echo "<tr>
            <td>{$objet->id_user}</td>
            <td>{$objet->nom} {$objet->prenom}</td>       
              <td>{$objet->email}</td>
               <td>{$objet->telephone}</td>
                <td>{$objet->adresse} -  {$objet->id_role}</td>
            <td>
                  <form action='' method='post'>
                 <input type='hidden' name='id_user' value='{$objet->id_user}'>
            <select name='editRole' onchange ='this.form.submit()' class='w-full bg-gray-100 border border-gray-300 rounded-lg p-2 text-sm'>

                    <option value='2' " . ($objet->id_role == 2 ? 'selected' : '') . ">Admin</option>
                    <option value='3' " . ($objet->id_role == 3 ? 'selected' : '') . ">Client</option>
           
            </select>
            </form>
            
            
            
            </td>
            <td class='flex align-center justify-center'>
                 <form   action='client.php' method='post'>
                  <input type='hidden' name='id_user' value='{$objet->id_user}'>
                    <div class='flex'>
                        <button type='submit' name='delete' value='$id'>
                            <span class='text-red-400 cursor-pointer material-symbols-outlined'>
                                delete
                            </span>
                        </button>
                        <button type='submit' name='archive' value='$id'>
                            <span class='text-red-400 cursor-pointer material-symbols-outlined'>
                                folder
                            </span>
                        </button>
        <button  id='edit' name='edit' value='$id'>
            <span class='text-yellow-400 cursor-pointer material-symbols-outlined'>
                edit
            </span>
        </button>

          
    </div>
</form>
            </td>
        </tr>";
    }
    echo "</tbody></table></div>";
} else {
    echo "<p>Aucun client trouvé.</p>";
}
}

?>
<?php
$content = ob_get_clean(); 
include 'layout.php'; 
?>
