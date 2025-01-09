<?php
ob_start(); 
session_start() ;
/*session_start() ;
    if($_SESSION['id_role'] !=1 ){ //client
      header("location: erreur.php") ;
      exit ;
    }
    else if($_SESSION['id_role'] ==1  ){ //admin 
       $id_user = $_SESSION['id'] ; 
    }*/
$title = "Gestion des Véhicules";
require "../backend/classe_Vehicule.php";
require "../backend/classe_Categorie.php";
require_once __DIR__ . '/../../includ/DB.php';
require_once __DIR__ . '/../../includ/DatabaseManager.php';



$dbManager = new DatabaseManager();
$objVehicule = new Vehicule($dbManager);
$actionEdit=false ;

if(isset($_POST["edit"]) ){
    $actionEdit=true ;
    $id =$_POST['edit'];
    $newVehicule = new Vehicule($dbManager , $id );
    $objVehicule  = $newVehicule->getById($id) ;

    if ($objVehicule) { 
        //header("Location: Vehicule.php");
        //exit; 
    } else {
        echo "<p>Erreur : Remplissage de formulaire  </p>";
    }
}
?>






   <!-- #form -->
   <div class="relative mx-20 mb-10">
    <button onclick="openModal('modal')" class=" float-right flex flex-row justify-around gap-2.5 text-indigo-900 hover:text-green-500" id="ShowForm">
        <span class="material-symbols-outlined">
            add_task  
        </span>
        <span> Ajouter</span>
    </button>
</div>

<div id="modal" class="<?= $actionEdit ? '' : 'hidden' ?> fixed inset-0 flex items-center z-50 justify-center bg-white bg-opacity-50">
    <div class="relative p-6 shadow-xl rounded-lg bg-white text-gray-900 overflow-y-auto lg:w-1/3">
        <span id="closeForm" onclick="closeModal('modal')" class="absolute right-4 top-4 text-gray-600 hover:text-gray-900 cursor-pointer material-symbols-outlined text-2xl">cancel</span>
        <h2 class="text-2xl font-bold mb-6 text-center text-yellow-500"><?= $actionEdit ? 'Modifier Véhicule' : 'Ajouter Véhicule' ?></h2>
        <p id="pargErreur" class="hidden text-sm font-semibold px-4 py-2 mb-4 text-red-700 bg-red-100 border border-red-400 rounded">
        </p>
        <form id="formulaire" class="flex flex-col gap-4" action="Vehicule.php" method="post" enctype="multipart/form-data">
            <input id="id_input" type="hidden" name="id" value="<?= $actionEdit ? $objVehicule->id_vehicule : 0 ?>">
            <input id="action" type="hidden" name="action" value="<?= $actionEdit ? 'edit' : 'ajout' ?>">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="nom" class="block font-medium mb-1">Nom</label>
                    <input id="nom" name="nom" type="text" placeholder="Nom du véhicule" value="<?= $actionEdit ? $objVehicule->nom : '' ?>" class="inputformulaire w-full bg-gray-50 border border-gray-300 rounded-lg p-2 text-sm" required>
                </div>
                <div>
                    <label for="prix" class="block font-medium mb-1">Prix</label>
                    <input id="prix" name="prix" type="number" placeholder="Prix du véhicule" value="<?= $actionEdit ? $objVehicule->prix : '' ?>" class="inputformulaire w-full bg-gray-50 border border-gray-300 rounded-lg p-2 text-sm" required>
                </div>
                <div>
                    <label for="marque" class="block font-medium mb-1">Marque</label>
                    <input id="marque" name="marque" type="text" placeholder="Marque du véhicule" value="<?= $actionEdit ? $objVehicule->marque : '' ?>" class="inputformulaire w-full bg-gray-50 border border-gray-300 rounded-lg p-2 text-sm" required>
                </div>

                <div>
                    <label for="model" class="block font-medium mb-1">Modèle</label>
                    <input id="model" name="model" type="text" placeholder="Modèle du véhicule" value="<?= $actionEdit ? $objVehicule->model : '' ?>" class="inputformulaire w-full bg-gray-50 border border-gray-300 rounded-lg p-2 text-sm" required>
                </div>
                <div>
                    <label for="id_categorie" class="block font-medium mb-1">Catégorie</label>
                    <select id="id_categorie" name="id_categorie" class="inputformulaire w-full bg-gray-50 border border-gray-300 rounded-lg p-2 text-sm" required>
                        <!-- Remplissez avec les catégories depuis la base de données -->
                       
                        
                        <?php 
                          $newCateg = new Categorie($dbManager) ; 
                          $categories =  $newCateg->getAll() ;
                        
                        foreach ($categories as $categorie): 
                            ?>
                            <option value="<?= $categorie->id_categorie ?>"
                             <?= $actionEdit && $objVehicule->id_categorie == $categorie->id_categorie ? 
                             'selected' : '' ?>><?= $categorie->nom ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="urlPhoto" class="block font-medium mb-1">Photo</label>
                    <input id="urlPhoto" name="urlPhoto" type="file" accept="image/*" class="inputformulaire w-full bg-gray-50 border border-gray-300 rounded-lg p-2 text-sm" <?= !$actionEdit ? 'required' : '' ?>>
                </div>

          
            </div>

            <div class="flex justify-center">
                <button type="submit" name="valider" class="w-full bg-[#7F020F] hover:bg-red-700 text-white font-bold py-2 rounded-lg">Valider</button>
            </div>
        </form>
    </div>
</div>


<!---->

<?php

function uploadImage($file, $uploadsDir = 'uploads/', $maxSize = 2 * 1024 * 1024, $allowedTypes = ['image/jpeg', 'image/png', 'image/gif']) {
    if (isset($file) && $file['error'] === UPLOAD_ERR_OK) {
        $photoTmpName = $file['tmp_name'];
        $photoName = basename($file['name']);
        $photoSize = $file['size'];
        $photoType = mime_content_type($photoTmpName);

        // Vérification du type
        if (!in_array($photoType, $allowedTypes)) {
            return ['success' => false, 'message' => "Type de fichier non supporté. Veuillez utiliser JPEG, PNG ou GIF."];
        }

        // Vérification de la taille
        if ($photoSize > $maxSize) {
            return ['success' => false, 'message' => "Le fichier est trop volumineux. Limite de " . ($maxSize / (1024 * 1024)) . " Mo."];
        }

        // Création du chemin d'enregistrement avec un nom unique
        $photoPath = $uploadsDir . uniqid() . '-' . $photoName;
        // Déplacement du fichier
        if (move_uploaded_file($photoTmpName, "$photoPath")) {
            return ['success' => true, 'filePath' => $photoPath];
        } else {
            return ['success' => false, 'message' => "Erreur lors de l'upload de l'image."];
        }
    } else {
        return ['success' => false, 'message' => "Aucun fichier sélectionné ou erreur lors de l'upload."];
    }
}

// Modifier Vehicule ou ajouter
if (isset($_POST['valider'])  ) {
    $nom = $_POST['nom'];
    $_id = $_POST['id'];
    $marque = $_POST['marque'];
    $model = $_POST['model'];
    $disponibilite = 1;
    $prix =  floatval($_POST['prix']);
    $archive =0 ;
    $id_categorie = $_POST['id_categorie'];
    $uploadResult = uploadImage($_FILES['urlPhoto']);
    $urlPhoto = $uploadResult['filePath'];
    

    $id = $_POST['id'] ;  // 0 si l premier ajout sinon il comport la value de l id de l element a modifier
    $newVehicule = new Vehicule(
        $dbManager,  
        $id,  
        $nom, 
        $marque, 
        $model,  
        $prix, 
        $archive,
        $urlPhoto,  
        $id_categorie  
    );
   //  var_dump($newVehicule->photo) ; 
    // exit ; 
    if( $_POST['id']==0  && $_POST['action']=='ajout'){
        $result = $newVehicule->AjouterVehicule() ;
    }
    if($_POST['id']!=0  && $_POST['action']=='edit'){
        $result = $newVehicule->EditerVehicule() ;
    }
  
    if ($result) { 
        header("Location: Vehicule.php");
        exit; 
    } else {
        echo "<p>Erreur : insertion </p>";
    }
}





//https://www.w3schools.com/php/php_mysql_prepared_statements.asp
// methode plus securise car il prepare la requete avant de l appler en plus il consomme
if (isset($_POST["delete"])) {
    $id = intval($_POST["delete"]); // S'assurer que l'ID est un entier
    echo "id : ".$id;
           $dbManager = new DatabaseManager();
           $newVehicule = new Vehicule($dbManager , $id);
            $result= $newVehicule->supprimerVehicule();
            if ($result) { 
                header("Location: Vehicule.php");
                exit; 
            } else {
                echo "<p>Erreur : delete </p>";
            }
        }
// Afficher les clients
affiche() ; 
function affiche() {
    $dbManager = new DatabaseManager();
    $newVehicule = new Vehicule($dbManager);
    $result = $newVehicule->getAll(); 
    if ($result) {
        echo "<div class='listeTable'><table border='1'>";
        echo "<tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Marque</th>
                <th>Modèle</th>
                <th>prix</th>
                <th>Catégorie</th>
                <th>Action</th>
              </tr>";
        
        foreach ($result as $objet) {
            // Utilisation des propriétés adaptées à la table vehicule
            $id = $objet->id_vehicule;
            $disponibilite = $objet->disponibilite === '1' ? 'Disponible' : 'Indisponible';

            echo "<tr>
                <td>{$objet->id_vehicule}</td>
                <td>{$objet->nom}</td>
                <td>{$objet->marque}</td>
                <td>{$objet->model}</td>
                <td>{$objet->prix}</td>
                <td>{$objet->id_categorie}</td>
                <td>
                    <form action='Vehicule.php' method='post'>
                        <div class='flex'>
                            <button type='submit' name='delete' value='$id'>
                                <span class='text-red-400 cursor-pointer material-symbols-outlined'>
                                    delete
                                </span>
                            </button>
                            <button type='submit' name='edit' value='$id'>
                                <span class='text-yellow cursor-pointer material-symbols-outlined'>
                                    edit
                                </span>
                            </button>
                        </div>
                    </form>
                </td>
            </tr>";
        }
        echo "</table></div>";
    } else {
        echo "<p>Aucun véhicule trouvé.</p>";
    }
}



?>
<?php
$content = ob_get_clean(); 
include 'layout.php'; 
?>
