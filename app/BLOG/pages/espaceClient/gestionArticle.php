<?php
ob_start(); 
session_start() ;

require_once $_SERVER['DOCUMENT_ROOT'] . '/locationVoiture/autoload.php';

use Models\Article;
use Models\DatabaseManager;
use Models\client ;
use Models\Theme;

session_start() ;
 if ($_SESSION['id_role'] == 1 ) { // client ou visiteur
    header("location: erreur.php");
   exit;
} else if ( $_SESSION['id_role'] == 2) { // admin ou superAdmin
     $id_user = $_SESSION['id_user'];
 }


// $_SESSION["id_user"]=5;
// $id_user = $_SESSION["id_user"];


$dbManager = new DatabaseManager();
$objArticle = new Article($dbManager);
$actionEdit = false;







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

// Modifier Article ou ajouter
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
    $newArticle = new Article(
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
   //  var_dump($newArticle->photo) ; 
    // exit ; 
    if( $_POST['id']==0  && $_POST['action']=='ajout'){
        $result = $newArticle->AjouterArticle() ;
    }
    if($_POST['id']!=0  && $_POST['action']=='edit'){
        $result = $newArticle->EditerArticle() ;
    }
  
    if ($result) { 
        header("Location: Article.php");
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
           $newArticle = new Article($dbManager , $id);
            $result= $newArticle->delete();
            if ($result) { 
                header("Location: gestionArticle.php");
                exit; 
            } else {
                echo "<p>Erreur : delete </p>";
            }
        }
// Afficher les clients
affiche() ; 
function affiche() {
    $id_user = $_SESSION["id_user"];
    $dbManager = new DatabaseManager();
    $newArticle = new Article($dbManager);
    $newArticle->id_user = $id_user ; // visiteur  
    $result = $newArticle->getArticleByIdUser(); 
    if ($result) {
        echo "<div class='listeTable'><table border='1'>";
        echo "<tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Content</th>
                <th>Statut</th>
                <th>Action</th>
              </tr>";
        
        foreach ($result as $objet) {
            // Utilisation des propriétés adaptées à la table Article
            $id = $objet->id_article;

            echo "<tr>
                <td>{$objet->id_article}</td>
                <td>{$objet->title}</td>
                <td>".substr($objet->content, 0, 150)."</td>
                <td>{$objet->title_theme}</td>
                <td>
                    <form action='' method='post'>
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
        <form id="formulaire" class="flex flex-col gap-4" action="Article.php" method="post"   enctype="multipart/form-data">
            <input id="id_input" type="hidden" name="id" value="<?= $actionEdit ? $objArticle->id_Article : 0 ?>">
            <input id="action" type="hidden" name="action" value="<?= $actionEdit ? 'edit' : 'ajout' ?>">

            <div>
                <label for="nom" class="block font-medium mb-1">Nom</label>
                <input id="nom" name="nom" type="text" placeholder="Nom de la catégorie" value="<?= $actionEdit ? $objArticle->nom : '' ?>" class="inputformulaire w-full bg-gray-50 border border-gray-300 rounded-lg p-2 text-sm" required>
            </div>
            <div>
                <label for="description" class="block font-medium mb-1">Description</label>
                <textarea id="description" name="description" placeholder="Nom de la catégorie" value="<?= $actionEdit ? $objArticle->description : '' ?>" class="inputformulaire w-full bg-gray-50 border border-gray-300 rounded-lg p-2 text-sm" required> 
                </textarea>
            </div>


            <div id="divArticles" class="flex flex-col gap-2.5 ">
                <!-- ajout des Article par js  -->
             </div>
            <div class=" flex justify-between gap-8">
                <button type="button" id="addArticle_Btn"
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




<?php
$content = ob_get_clean(); 
include 'layout.php'; 
?>
