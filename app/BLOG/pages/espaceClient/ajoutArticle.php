<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/locationVoiture/autoload.php';

ob_start();

use Models\Article;
use Models\DatabaseManager;
use Models\client;
use Models\Theme;
use Models\Tag;
use Models\ArticleTags;

$dbManager = new DatabaseManager();


session_start() ;
 if ($_SESSION['id_role'] == 1 ) { // client ou visiteur
    header("location: erreur.php");
   exit;
} else if ( $_SESSION['id_role'] == 2) { // admin ou superAdmin
     $id_user = $_SESSION['id_user'];
 }


// $_SESSION["id_user"] = 5;
// $id_user =  $_SESSION["id_user"];

?>
<?php
function uploadImage($file, $uploadsDir = 'uploads/', $maxSize = 2 * 1024 * 1024, $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'])
{
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
    $id_article = $dbManager->getLastInsertId();
    // echo("id_article") ; 
    // var_dump($id_article);
    if ($result) {

      if (!empty($_POST['tags'])) {
        // Nettoyage et traitement des tags
        $tags_input = htmlspecialchars(trim($_POST['tags']));
        $tags = array_unique(array_filter(array_map('trim', explode(',', $tags_input))));

        foreach ($tags as $tag_name) {
          var_dump($tag_name); // Debug: Afficher le tag traité
          $tag = new Tag($dbManager, 0, $tag_name);
          // Vérifier si le tag existe
          $objetTag = $tag->getTagByName();
          if ($objetTag === null) {
            // Le tag n'existe pas, le créer
            $tag->add();
            $tag_id = $dbManager->getLastInsertId();
          } else {
            // Le tag existe, récupérer son ID
            $tag_id = $objetTag->id_tag;
          }

          // Ajouter la relation entre l'article et le tag
          $tag_article = new ArticleTags($dbManager, $id_article, $tag_id);
          $tag_article->linkTagToArticle();
        }
      } else {
        echo " l article n est pas ajouté";
      }
    }
  }
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
      <form method="POST" action="" enctype="multipart/form-data">
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
              <input id="urlPhoto" name="urlPhoto" type="file" accept="image/*" class="w-full p-3 border rounded-lg">
            </div>
            <!-- Tags -->
            <div class="">
              <label class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
              <input type="text" class="w-full p-3 border rounded-lg" id="tags-input" name="tags-input" placeholder="Add a tag and press Enter">
            </div>
            <div class="tag-container" id="tag-container"></div>
            <input type="hidden" name="tags" id="tags">


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
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const tagsInput = document.getElementById('tags-input');
    const tagsContainer = document.getElementById('tag-container');
    const tagsHiddenInput = document.getElementById('tags');
    let tags = [];

    tagsInput.addEventListener('keypress', (e) => {
      if (e.key === 'Enter') {
        e.preventDefault();
        const tagValue = tagsInput.value.trim();
        if (tagValue && !tags.includes(tagValue)) {
          tags.push(tagValue);
          const tagElement = document.createElement('div');
          tagElement.classList.add('tag');
          tagElement.textContent = tagValue;
          const removeButton = document.createElement('button');
          removeButton.textContent = 'x';
          removeButton.addEventListener('click', () => {
            tags = tags.filter(tag => tag !== tagValue);
            tagsContainer.removeChild(tagElement);
            updateTagsInput();
          });
          tagElement.appendChild(removeButton);
          tagsContainer.appendChild(tagElement);
          tagsInput.value = '';
          updateTagsInput();
        }
      }
    });

    function updateTagsInput() {
      tagsHiddenInput.value = tags.join(',');
    }
  });
</script>