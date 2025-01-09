<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/locationVoiture/autoload.php';

ob_start();

use Models\Article;
use Models\DatabaseManager;
use Models\client ;
use Models\Theme;

$dbManager = new DatabaseManager() ; 

$_SESSION["id_user"] = 5 ; 
$id_user =  $_SESSION["id_user"] ; 

?>
<?php

if (($_SERVER["REQUEST_METHOD"] == 'POST') && (isset($_POST["addArticle"]))) {
  $var_traget=[] ; 

  if (empty($_POST['articleTheme']) && empty($_POST['articleTitle']) && empty($_POST['articleContent'])) {
      echo "veuillez remplir les champs ";
      $var_traget=["veuillez remplir les champs "] ; 
      var_dump($_POST ) ; 
      die();
  } 
  else 
  {
  //
    $newArticle = new Article($dbManager ,  0 , $_POST['articleTitle'] ,  $_POST['articleContent']  ,$_POST['articleTheme'] ,  $id_user  ) ; 
    $result = $newArticle->add() ; 
    $var_traget .= $result ; 
    if ($result){
      echo "Ajout article ";
    } else {
      echo "non ajout  ";
    }
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
      <form method="POST" action="">
        <!-- Article Writing Section -->
        <div id="writeSection" class="space-y-6">
          <div class="space-y-4">
            <!-- Thème (sujet) de l'article -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Thème de l'article</label>
              <select id="articleTheme" class="w-full p-3 border rounded-lg">
               <option value="">Sélectionnez un thème</option>
               <?php $newTheme = new Theme($dbManager) ; 
                     $objets =  $newTheme->getAll() ;
                     foreach($objets as $objet) {
                     echo" <option value='".$objet->id_theme."'>".$objet->name."</option>" ;
                     }
                ?>
                   


                 <!-- <option value="sport">Sport Automobile</option>
                <option value="technique">Technique</option>
                <option value="essai">Essai routier</option>
                <option value="nouveaute">Nouveauté</option>
                <option value="ecologie">Écologie & Mobilité</option>
                <option value="lifestyle">Lifestyle & Luxe</option> -->
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
        <button onclick="addArticle()"  name="addArticle" class=" bg-blue-600 text-white px-12 py-2 rounded-lg hover:bg-blue-700">
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