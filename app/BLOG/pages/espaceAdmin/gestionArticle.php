<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/locationVoiture/autoload.php';
ob_start();
session_start() ;
 if ($_SESSION['id_role'] != 1 ) { // client ou visiteur
    header("location: erreur.php");
   exit;
} else if ( $_SESSION['id_role'] == 1) { // admin ou superAdmin
     $id_user = $_SESSION['id_user'];
 }

use Models\Article;
use Models\DatabaseManager;

$dbManager = new DatabaseManager();

if (isset($_POST["archive"])) {
    $id_article = intval($_POST["archive"]);
    $article = new Article($dbManager , $id_article);
    $article->archive();
}

if (isset($_POST["changeStatut"])) {
    $id_article = intval($_POST["id_article"]);
    $newStatut = $_POST["changeStatut"];
    $article = new Article($dbManager ,$id_article );
    $result = $article->changeStatut( $newStatut);
}



afficher($dbManager);

function afficher($dbManager)
{$article = new Article($dbManager) ;
   $articles =  $article->getArticles();
    if (!empty($articles)) {
        echo "<div class='listeTable'><table border='1'><thead>";
        echo "<tr>
                    <th>Réf</th>
                    <th>Title</th>
                    <th>Theme</th>
                    <th>Auteur</th>
                     <th>Publie</th>
                   
                       <th class='border border-gray-300 px-4 py-2'>
                        <i class='fa-solid fa-comment text-gray-600'></i>
                    </th>
                     <th>Statut</th>
                    <th>Archive</th>
               </tr></thead><tbody>";

        foreach ($articles as $objet) {
            $id = $objet->id_article;
           echo "<tr>
                <td>{$objet->id_article}</td>  
                 <td> $objet->title </td>
                <td> $objet->title_theme </td>
                <td> $objet->nom_user   $objet->prenom_user</td>
                <td>{$objet->created_at}</td>
                <td>{$objet->total_comment}</td>

             <td>
            <form action='' method='post'>
                <input type='hidden' name='id_article' value='{$objet->id_article}'>
                <select name='changeStatut' onchange='this.form.submit()' class='w-full bg-gray-100 border border-gray-300 rounded-lg p-2 text-sm'>
                    <option value='en attente'" . ($objet->statut === 'en attente' ? ' selected' : '') . ">En attente</option>
                    <option value='confirmé'" . ($objet->statut === 'confirmé' ? ' selected' : '') . ">Confirmée</option>
                    <option value='annulé'" . ($objet->statut === 'annulé' ? ' selected' : '') . ">Annulée</option>
                </select>
            </form>
           </td>
           
                    <td class='flex align-center justify-center'>
                        <form action='' method='post'>
                            <input type='hidden' name='id_article' value='{$objet->id_article}'>
                            <button type='submit' name='archive' value='$id'>
                                <span class='text-red-400 cursor-pointer material-symbols-outlined'>archive</span>
                            </button>
                        </form>
                    </td>
            </tr>";
        }
        echo "</tbody></table></div>";
    } else {
        echo "<p>Aucune réservation trouvée.</p>";
    }
}

$content = ob_get_clean();
include 'layout.php';
?>
