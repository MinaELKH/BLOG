<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/locationVoiture/autoload.php';

ob_start();

use Models\Article;
use Models\DatabaseManager;
use Models\Theme;
$dbManager = new DatabaseManager();

$_SESSION["id_user"] = 5;
$id_user =  $_SESSION["id_user"];

?>
<?php
// AJout d article 
if (($_SERVER["REQUEST_METHOD"] == 'POST') && (isset($_POST["addTheme"]))) {
  if (empty($_POST['title']) && empty($_POST['description']) ) {
    echo "veuillez remplir les champs ";
  } else {
    $newTheme = new Theme($dbManager,  0, $_POST['title'],  $_POST['description']);
    $result = $newTheme->add();
    //  var_dump($result) ;
    //  die();
    }
  }


?>

<script src="https://cdn.tailwindcss.com"></script>

<div class="container mx-auto p-6">
  <div class="bg-white rounded-xl shadow-lg p-6">
    <!-- Formulaire d'ajout de thème -->
    <h1 class="text-xl font-bold text-gray-800 mb-4">Ajouter un Thème</h1>
    <form method="POST" action="">
      <div class="space-y-6">
        <!-- Nom du Thème -->
        <div>
          <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Nom du Thème</label>
          <input type="text" id="title" name="title" class="w-full p-3 border rounded-lg" placeholder="Entrez le nom du thème">
        </div>
        <!-- Description du Thème -->
        <div>
          <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
          <textarea id="description" name="description" class="w-full h-32 p-3 border rounded-lg resize-none" placeholder="Entrez la description du thème"></textarea>
        </div>
        <!-- Bouton de soumission -->
        <div>
          <button type="submit" name="addTheme" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
            Ajouter le Thème
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<?php
$content = ob_get_clean();
include('layout.php');
?>
