<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/locationVoiture/autoload.php';

ob_start();

use Models\Article;
use Models\DatabaseManager;
use Models\client;
use Models\Theme;

$dbManager = new DatabaseManager();

$_SESSION["id_user"] = 5;
$id_user =  $_SESSION["id_user"];

?>
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
      if (move_uploaded_file($photoTmpName, "../$photoPath")) {
          return ['success' => true, 'filePath' => $photoPath];
      } else {
          return ['success' => false, 'message' => "Erreur lors de l'upload de l'image."];
      }
  } else {
      return ['success' => false, 'message' => "Aucun fichier sélectionné ou erreur lors de l'upload."];
  }
}
// AJout d article 
if (($_SERVER["REQUEST_METHOD"] == 'POST') && (isset($_POST["addArticle"]))) {
 if (empty($_POST['id_theme']) && empty($_POST['articleTitle']) && empty($_POST['articleContent'])) {
    echo "veuillez remplir les champs ";
  } else {

    $uploadResult = uploadImage($_FILES['urlPhoto']);
    $urlPhoto = $uploadResult['filePath'];
    $newArticle = new Article($dbManager,  0, $_POST['articleTitle'],  $_POST['articleContent'], $urlPhoto, intval($_POST['id_theme']),  $id_user);
    $result = $newArticle->add();

    if ($result) {
      echo "Ajout article ";
    } else {
      echo "non ajout  ";
    }

  }
  die();
}
// edit
if (isset($_POST["edit"])) {
  $actionEdit = true;
  $id = $_POST['edit'];
  $newArticle = new Article($dbManager, $id);
  $objArticle  = $newArticle->getArticleById();

  if ($objArticle) {
    //header("Location: Article.php");
    //exit; 
  } else {
    echo "<p>Erreur : Remplissage de formulaire  </p>";
  }
}
?>

<script src="https://cdn.tailwindcss.com"></script>

<div class="container mx-auto p-6">
  <div class="bg-white rounded-xl shadow-lg p-6">
    <!-- Navigation -->
    <nav class="border-b pb-4 mb-6">
      <div class="flex space-x-4">
        <button onclick="switchTab('write')" id="writeTab" class="px-4 py-2 rounded-lg bg-gray-100">
          Rédiger un Article
        </button>
        <button onclick="switchTab('tags')" id="tagsTab" class="px-4 py-2 rounded-lg">
          Gérer les Tags
        </button>
      </div>
    </nav>


    <div>
      <form method="POST" action=""  enctype="multipart/form-data">
        <!-- Article Writing Section -->
        <div id="writeSection" class="space-y-6">
          <div class="space-y-4">
            <!-- Thème (sujet) de l'article -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Thème de l'article</label>
              <select name="id_theme" id="id_theme" class="w-full p-3 border rounded-lg">
                <option value="">Sélectionnez un thème</option>
                <?php
                $newTheme = new Theme($dbManager);
                $objets = $newTheme->getAll();
                foreach ($objets as $objet) {
                  echo "<option value='" . $objet->id_theme . "'>" . $objet->name . "</option>";
                }
                ?>
              </select>
            </div>

            <!-- Titre -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Titre de l'article</label>
              <input type="text" id="articleTitle" name="articleTitle" class="w-full p-3 border rounded-lg" placeholder="Entrez le titre">
            </div>

            <!-- Contenu -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Contenu de l'article</label>
              <textarea id="articleContent" name="articleContent" class="w-full h-64 p-3 border rounded-lg resize-none" placeholder="Rédigez votre article..."></textarea>
            </div>
           <!-- img -->
           <div>
                    <label for="urlPhoto" class="block text-sm font-medium text-gray-700 mb-2">Photo</label>
                    <input id="urlPhoto" name="urlPhoto" type="file" accept="image/*" class="w-full p-3 border rounded-lg" >
            </div>
            <!-- Tags -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
              <div id="tagsContainer" name="tagsContainer" class="flex flex-wrap gap-2 mb-4"></div>
            </div>

          </div>
        </div>

        <!-- Tags Management Section -->
        <div id="tagsSection" class=" space-y-6 my-8">
          <div class="flex gap-2 mb-4">
            <input type="text" id="newTagInput" class="flex-1 p-2 border rounded-lg" placeholder="Nouveau tag">
            <button onclick="addTag()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
              Ajouter
            </button>
          </div>
          <div id="existingTags" class="grid grid-cols-2 md:grid-cols-3 gap-2">
            <!-- Ajout tag --->
          </div>
        </div>



        <!-- Submit Button -->
        <button onclick="addArticle()" name="addArticle" class=" bg-blue-600 text-white px-12 py-2 rounded-lg hover:bg-blue-700">
          Publier l'article
        </button>
      </form>
    </div>
  </div>
</div>

<?php
$content = ob_get_clean();
include('layout.php');
?>