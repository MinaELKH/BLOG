<?php
use Models\DatabaseManager;
use Models\Statistics;


$dbManager = new DatabaseManager();
$stats = new Statistics($dbManager);


$globalStats = $stats->getGlobalStatistics();


?>
<html lang="fr">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>
   Tableau de bord
  </title>
  <script src="https://cdn.tailwindcss.com">
  </script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&amp;display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"><!--icon usee-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
 
  <script src='../../../../public/js/main.js' defer></script>
  <script src='../../../../public/js/burger.js' defer></script>

    <link rel="stylesheet" href="../../../../public/css/style.css" />
  <style>
   body {
            font-family: 'Nunito', sans-serif;
        }
  </style>
 </head>
 <body class="bg-yellow-100">
  <div class="flex">
   <!-- Barre latérale -->
   <div class="bg-gray-600 text-white w-64 min-h-screen p-4">
    <div class="flex items-center mb-8">
    <span class="text-xl font-bold">
      ZP articles
     </span>
    </div>
    <div class="mb-8">
     <input class="w-full p-2 rounded bg-gray-200 text-white" placeholder="Recherche" type="text"/>
    </div>
    <nav>
     <ul>
      <li class="mb-4">
       <a class="flex items-center p-2 rounded bg-pink-500" href="#">
        <i class="fas fa-tachometer-alt mr-2">
        </i>
        Tableau de bord
       </a>
      </li>
      <li class="mb-4">
       <a   href="AjoutTheme.php"  class="flex items-center p-2 rounded hover:bg-gray-800">
       <i class="fas fa-pen mr-2"> 
        </i>
           Nouvel theme
       </a>
      </li>
      <li class="mb-4">
       <a  href="gestionArticle.php" class="flex items-center p-2 rounded hover:bg-gray-800" >
        <i class="fas fa-file-alt mr-2">
        </i>
        les articles 
       </a>
      </li>
      <li class="mb-4">
       <a href="confirmerArticle" class="flex items-center p-2 rounded hover:bg-gray-800" >
        <i class="fas fa-chart-line mr-2">
        </i>
         Les Articles en attente
       </a>
      </li>
     
     </ul>
    </nav>
    <div class="mt-auto text-gray-500 text-sm">
     Version 1.0.1
    </div>
   </div>
   <!-- Contenu principal -->
   <div class="flex-1 p-6">
    <div class="flex justify-between items-center mb-6 bg-gray-400 p-6 rounded">
     <div>
      <h1 class="text-2xl font-bold">
       Bonjour  Admin
      </h1>

     </div>
     <img alt="Illustration d'une personne travaillant sur un ordinateur" class="w-40 h-24" height="100" src="https://storage.googleapis.com/a1aa/image/ycEOevfPmrpKLUkLC8OZcUkd3Be5CecaFDFPZbxhnvgNYZLQB.jpg" width="150"/>
    </div>


    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
     <div class="bg-teal-100 p-4 rounded">
      <div class="flex items-center">
       <i class="fas fa-wallet text-2xl text-teal-500 mr-4">
       </i>
       <div>
        <h2 class="text-xl font-bold">
         <?php echo $globalStats["totalArticles"] ?>
        </h2>
        <p class="text-gray-600">
         Total des Articles 
        </p>
       </div>
      </div>
     </div>
     <div class="bg-purple-100 p-4 rounded">
      <div class="flex items-center">
       <i class="fas fa-file-alt text-2xl text-purple-500 mr-4">
       </i>
       <div>
        <h2 class="text-xl font-bold">
        <?php  echo  $globalStats["unconfirmedArticles"] ?>
        </h2>
        <p class="text-gray-600">
         Demandes d'articles
        </p>
       </div>
      </div>
     </div>
     <div class="bg-pink-100 p-4 rounded">
      <div class="flex items-center">
       <i class="fas fa-clock text-2xl text-pink-500 mr-4">
       </i>
       <div>
        <h2 class="text-xl font-bold">
         Meilleur article
        </h2>
        <p class="text-gray-600">
        <?php 
           $res = $globalStats["bestArticle"] ; 
           echo $res->title ." ". $res->total  ; 

           ?>
        </p>
       </div>
      </div>
     </div>
    </div>

<main>
                      <?php
                        // Main contient les autres pages 
                        echo isset($content) ? $content : '<p>Bienvenue sur le site de réservation de voyages.</p>';
                        ?>
<main>

   </div>
  </div>
 </body>
</html>
