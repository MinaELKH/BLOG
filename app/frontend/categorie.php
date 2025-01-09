<?php
ob_start(); 
session_start() ;
$title = "Gestion des Catégories";
require "../backend/classe_Categorie.php";
require "../backend/classe_Vehicule.php";
require_once __DIR__ . '/../../includ/DB.php';
require_once __DIR__ . '/../../includ/DatabaseManager.php';
$dbManager = new DatabaseManager();
$objCategorie = new Categorie($dbManager);
$actionEdit = false;

if (isset($_POST["edit"])) {
    $actionEdit = true;
    $id = $_POST['edit'];
    $newCategorie = new Categorie($dbManager, $id);
    $objCategorie = $newCategorie->getById($id);

    if (!$objCategorie) {
        echo "<p>Erreur : Remplissage de formulaire</p>";
    }
}
?>

<div class="relative mx-20 mb-10">
    <button onclick="openModal('modal')" class="float-right flex flex-row justify-around gap-2.5 text-indigo-900 hover:text-green-500" id="ShowForm">
        <span class="material-symbols-outlined">add_task</span>
        <span>Ajouter</span>
    </button>
</div>

<div id="modal" class="<?= $actionEdit ? '' : 'hidden' ?> fixed inset-0 flex items-center z-50 justify-center bg-white bg-opacity-50">
    <div class="relative p-6 shadow-xl rounded-lg bg-white text-gray-900 overflow-auto h-[500px] lg:w-1/3">
        <span id="closeForm" onclick="closeModal('modal')" class="absolute right-4 top-4 text-gray-600 hover:text-gray-900 cursor-pointer material-symbols-outlined text-2xl">cancel</span>
        <h2 class="text-2xl font-bold mb-6 text-center text-yellow-500"><?= $actionEdit ? 'Modifier Catégorie' : 'Ajouter Catégorie' ?></h2>
        <p id="pargErreur" class="hidden text-sm font-semibold px-4 py-2 mb-4 text-red-700 bg-red-100 border border-red-400 rounded"></p>
        <form id="formulaire" class="flex flex-col gap-4" action="Categorie.php" method="post"   enctype="multipart/form-data">
            <input id="id_input" type="hidden" name="id" value="<?= $actionEdit ? $objCategorie->id_categorie : 0 ?>">
            <input id="action" type="hidden" name="action" value="<?= $actionEdit ? 'edit' : 'ajout' ?>">

            <div>
                <label for="nom" class="block font-medium mb-1">Nom</label>
                <input id="nom" name="nom" type="text" placeholder="Nom de la catégorie" value="<?= $actionEdit ? $objCategorie->nom : '' ?>" class="inputformulaire w-full bg-gray-50 border border-gray-300 rounded-lg p-2 text-sm" required>
            </div>
            <div>
                <label for="description" class="block font-medium mb-1">Description</label>
                <textarea id="description" name="description" placeholder="Nom de la catégorie" value="<?= $actionEdit ? $objCategorie->description : '' ?>" class="inputformulaire w-full bg-gray-50 border border-gray-300 rounded-lg p-2 text-sm" required> 
                </textarea>
            </div>


            <div id="divVehicules" class="flex flex-col gap-2.5 ">
                <!-- ajout des vehicule par js  -->
             </div>
            <div class=" flex justify-between gap-8">
                <button type="button" id="addVehicule_Btn"
                    class="bg-orange-500 opacity-50 hover:bg-green-700 text-white font-bold py-1 px-3 rounded-lg">
                    +
                </button>
            </div>



            <div class="flex justify-center">
                <button type="submit" name="valider" class="w-full bg-orange-500 hover:bg-orange-600 opacity-70 inline-block text-center text-white ">Valider</button>
            </div>
        </form>
    </div>
</div>
<script>
        document.addEventListener('DOMContentLoaded', function() {
            const divVehicules = document.getElementById('divVehicules');
            const addVehicule_Btn = document.getElementById('addVehicule_Btn');
            const firstVehicule = document.getElementById('firstVehicule');
          //  firstVehicule.querySelector('.removeVehicule').addEventListener('click', function() {
          //          divVehicules.removeChild(firstVehicule);
          //      });
            addVehicule_Btn.addEventListener('click', function() {
                // alert ("help") ; 
                const newVehicule = document.createElement('div');
                newVehicule.className = 'relative  border-b-2 border-gray-500 gap-4 p-2.5';
                newVehicule.innerHTML = ` 
                    <!-- Nom du Vehicule -->
                     <span 
            class=" removeVehicule absolute right-1 top-1 text-red-600 hover:text-gray-900 cursor-pointer material-symbols-outlined text-xl">
            cancel
        </span>
        
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type='hidden' name="AjoutMultiple" value=''>
                <div> 
                    <label for="nom" class="block font-medium mb-1">Nom</label>
                    <input id="nom" name="vehicules[nom][]" type="text" placeholder="Nom du véhicule" value="" class="inputformulaire w-full bg-gray-50 border border-gray-300 rounded-lg p-2 text-sm" required>
                </div>
                <div>
                    <label for="prix" class="block font-medium mb-1">Prix</label>
                    <input id="prix" name="vehicules[prix][]" type="number" placeholder="Prix du véhicule" value="" class="inputformulaire w-full bg-gray-50 border border-gray-300 rounded-lg p-2 text-sm" required>
                </div>
                <div>
                    <label for="marque" class="block font-medium mb-1">Marque</label>
                    <input id="marque" name="vehicules[marque][]" type="text" placeholder="Marque du véhicule" value="" class="inputformulaire w-full bg-gray-50 border border-gray-300 rounded-lg p-2 text-sm" required>
                </div>

                <div>
                    <label for="model" class="block font-medium mb-1">Modèle</label>
                    <input id="model" name="vehicules[model][]" type="text" placeholder="Modèle du véhicule" value="" class="inputformulaire w-full bg-gray-50 border border-gray-300 rounded-lg p-2 text-sm" required>
                </div>
              

                           <div class="col-span-2">
                <label for="photo" class="block text-sm font-medium text-gray-700">Photo</label>
                <input name="vehicules[imgVehicule][]" type="file" accept="image/*" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>
          
            </div>

        
                `;
                divVehicules.appendChild(newVehicule);

                // Ajout de l'écouteur d'événements de suppression
                newVehicule.querySelector('.removeVehicule').addEventListener('click', function() {
                    divVehicules.removeChild(newVehicule);
                });
            });
        });
    </script>


<?php
// edite add
if (isset($_POST['valider']) && !isset($_POST['AjoutMultiple'])) {
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $id = $_POST['id'];

    $newCategorie = new Categorie($dbManager, $id, $nom , $description);

    if ($_POST['id'] == 0 && $_POST['action'] == 'ajout') {
        $result = $newCategorie->ajouterCategorie();
    }

    if ($_POST['id'] != 0 && $_POST['action'] == 'edit') {
        $result = $newCategorie->editerCategorie();
    }

    if ($result) {
        header("Location: Categorie.php");
        exit;
    } else {
        echo "<p>Erreur : insertion</p>";
    }
}

if (isset($_POST["delete"])) {
    $id = intval($_POST["delete"]);
    $newCategorie = new Categorie($dbManager, $id);
    $result = $newCategorie->supprimerCategorie();

    if ($result) {
        header("Location: Categorie.php");
        exit;
    } else {
        echo "<p>Erreur : suppression</p>";
    }
}

affiche();
function affiche() {
    $dbManager = new DatabaseManager();
    $newCategorie = new Categorie($dbManager);
    $result = $newCategorie->getAll();

    if ($result) {
        echo "<div class='listeTable'><table border='1'>";
        echo "<tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Description</th>
                <th>Action</th>
              </tr>";

        foreach ($result as $objet) {
            $id = $objet->id_categorie;

            echo "<tr>
                <td>{$objet->id_categorie}</td>
                <td>{$objet->nom}</td>
                <td>{$objet->description}</td>
                <td>
                    <form action='Categorie.php' method='post'>
                        <div class='flex'>
                            <button type='submit' name='edit' value='$id'>
                                  <span class='text-red-400 cursor-pointer material-symbols-outlined'>
                                edit
                            </span>
                            </button>
                            <button type='submit' name='delete' value='$id'>      <span class='text-red-400 cursor-pointer material-symbols-outlined'>
                                delete
                            </span></button>
                        </div>
                    </form>
                </td>
              </tr>";
        }

        echo "</table></div>";
    } else {
        echo "<p>Aucune catégorie trouvée.</p>";
    }
}


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
      //  $photoPath1 = $uploadsDir . uniqid() . '-' . $photoName;
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

if ($_SERVER["REQUEST_METHOD"] == "POST" &&  isset($_POST['valider']) && isset($_POST['AjoutMultiple'])) {

    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $id = $_POST['id'];

    $newCategorie = new Categorie($dbManager, $id, $nom , $description );
    $result = $newCategorie->ajouterCategorie();
    $id_categorie = $dbManager->getLastInsertId() ; 
    var_dump($id_categorie) ; 
    if (isset($_POST['vehicules']['nom'])) {
            $nom = $_POST['vehicules']['nom'];
            $marque = $_POST['vehicules']['marque'];
            $model = $_POST['vehicules']['model'];
            $prix =  ($_POST['vehicules']['prix']);

          //  $uploadResult = uploadImage($_FILES['vehicules']['urlPhoto']);
          //  $urlPhoto = $uploadResult['filePath'];

            $archive =0 ;
        
      
        for ($i = 0; $i < count($nom); $i++) {
                $nomvehicule =  $nom[$i];
                $marque = $marque[$i];
                $model = $model[$i]; 
                // si l admin ne veux pas entrer le prix des le debut 
                if (is_array($prix)) {
                    if (isset($prix[$i])) {
                        $prix = floatval($prix[$i]);
                    } else {
                    
                        $prix = 0.0; // Valeur par défaut
                    }}
               // vehicules[urlPhoto][]"

               if (isset($_FILES['vehicules']['name']['imgVehicule'][$i])) {
                $file = [
                    'name' => $_FILES['vehicules']['name']['imgVehicule'][$i],
                    'type' => $_FILES['vehicules']['type']['imgVehicule'][$i],
                    'tmp_name' => $_FILES['vehicules']['tmp_name']['imgVehicule'][$i],
                    'error' => $_FILES['vehicules']['error']['imgVehicule'][$i],
                    'size' => $_FILES['vehicules']['size']['imgVehicule'][$i],
                ];
            
              
                
                    $uploadResult = uploadImage($file);  
                 

                  if ($uploadResult['success']) {
                    $urlPhoto= $uploadResult['filePath'];
                    $newVehicule = new Vehicule(
                        $dbManager,  
                        $id,  
                        $nomvehicule, 
                        $marque, 
                        $model,   
                        $prix, 
                        $archive,
                        $urlPhoto,  
                        $id_categorie  
                    );

                     
                    $result = $newVehicule->AjouterVehicule() ;
                    } else {
                        // Gestion des erreurs de téléchargement
                        echo "<script>alert('Erreur de téléchargement pour l'image du vehicule " . htmlspecialchars($nomvehicule, ENT_QUOTES, 'UTF-8') . "');</script>";
                    }
                } 
            
        }
    }



}

?>
<?php
$content = ob_get_clean(); 
include 'layout.php'; 
?>
