<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/locationVoiture/autoload.php';

use Models\Article;
use Models\Theme;
use Models\DatabaseManager;
use Models\ArticleTags;
use Models\Favorite;

$dbManager = new DatabaseManager();

?>
<!-- Add to favorite -->
<?php
if (isset($_POST["addFavoris"])) {
    $newFav = new Favorite($dbManager, 0,  intval($_POST['id_article']), intval($id_user));
    $newFav->add();
}
if (isset($_POST["deleteComment"])) {
    $newFav = new Favorite($dbManager, intval($_POST['id_favorite']));
    $newFav->delete();
}
?>


<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>
        Blog Page
    </title>
    <script src="https://cdn.tailwindcss.com">
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&amp;display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800">
    <header class="bg-white shadow mb-4">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="text-2xl font-bold text-indigo-900">Sada.</div>
            <nav class="flex items-center space-x-6">
                <ul class="flex space-x-6 text-indigo-900">
                    <li><a class="hover:text-indigo-600" href='home.php'>Home</a></li>
                    <li><a class="hover:text-indigo-600" href="theme.php">Themes</a></li>
                    <li><a class="hover:text-indigo-600" href="article.php">Articles</a></li>
                    <li><a class="hover:text-indigo-600" href="#">Blog</a></li>
                    <li><a class="hover:text-indigo-600" href="#">Shop</a></li>
                    <li><a class="hover:text-indigo-600" href="#">Elements</a></li>
                </ul>
                <div class="relative">
                    <form action="" method="post">
                        <div class="relative">
                            <input
                                type="text"
                                name="search"
                                class="border border-gray-300 rounded-lg py-2 px-4 pl-10 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                placeholder="Search...">
                                <input type="submit"   name="btnsearch" style="display: none;">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
                        </div>
                    </form>
                </div>
            </nav>
        </div>
    </header>
    <main class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-4">
            Blog
        </h1>
        <div class="flex flex-wrap -mx-4">
            <aside class="w-full lg:w-1/4 px-4 mb-8 lg:mb-0">
                <div class="bg-white p-6 rounded-lg shadow mb-8">
                    <div class="relative">
                        <input class="w-full p-3 border rounded-lg" placeholder="Search..." type="text" />
                        <i class="fas fa-search absolute top-3 right-3 text-gray-400">
                        </i>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow mb-8">
                    <h2 class="text-xl font-bold mb-4">
                        Categories
                    </h2>
                    <ul class="space-y-2">

                        <?php
                        $newTheme = new Theme($dbManager);
                        $objets =  $newTheme->getAll();
                        foreach ($objets as $objet) {
                            echo " 
                            <form method='POST' action=''>
                                <li>
                                <input type='hidden' name='nomTheme'  value= '" . $objet->name . "'>
                                <button  name='btnShowTheme' value=' " . $objet->id_theme . "' class='text-gray-600 hover:text-indigo-900' href='#'> 
                                    " . $objet->name . "
                                    </button>
                                </li>
                            </form>";
                        }
                        ?>

                    </ul>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h2 class="text-xl font-bold mb-4">
                        Instagram
                    </h2>
                    <div class="grid grid-cols-3 gap-2">
                        <img alt="Instagram image 1" class="w-full h-full object-cover rounded-lg" height="100" src="https://storage.googleapis.com/a1aa/image/aAlwYaUP1JrQIl7yoIabYIK1wPjZs6iAjKXfcX3iVACG3aBKA.jpg" width="100" />
                        <img alt="Instagram image 2" class="w-full h-full object-cover rounded-lg" height="100" src="https://storage.googleapis.com/a1aa/image/2DE7eECTjyzkIChKWSNIAsoT1FyfOipOoLhrwLfla9lf3WLQB.jpg" width="100" />
                        <img alt="Instagram image 3" class="w-full h-full object-cover rounded-lg" height="100" src="https://storage.googleapis.com/a1aa/image/QenYMzdfdZjJHkGbGWEIAPMAXtTNgpiAkMvyFdluAaF7t1CUA.jpg" width="100" />
                        <img alt="Instagram image 4" class="w-full h-full object-cover rounded-lg" height="100" src="https://storage.googleapis.com/a1aa/image/KEfHlz2ig8TvfkAz0mk2liABLcUcgaJfAIQzX5TduMYQcrFoA.jpg" width="100" />
                        <img alt="Instagram image 5" class="w-full h-full object-cover rounded-lg" height="100" src="https://storage.googleapis.com/a1aa/image/xRyYtZfaGUXmBS2GKeleg79ioTJrcz214Zif1xde8GGovtWgC.jpg" width="100" />
                        <img alt="Instagram image 6" class="w-full h-full object-cover rounded-lg" height="100" src="https://storage.googleapis.com/a1aa/image/jcnbffFHNEiNDUVFBSzHJJtGkJVaPpfbIEeSOENyUPNfxtWgC.jpg" width="100" />
                    </div>
                </div>
            </aside>
            <section class="w-full lg:w-3/4 px-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8">
                    <?php
                    $newArticle = new Article($dbManager);



                    if (isset($_POST['search'])) {
                        $MotSearch = trim($_POST['search']);
                        $result = $newArticle->getSearch($MotSearch);
                        // print_r($result);
                        // die();

                    } else if (isset($_POST["btnShowTheme"])) {
                        $newArticle->id_theme = $_POST["btnShowTheme"];
                        $result = $newArticle->getArticleByIdTheme();

                    } else {
                        $newArticle->id_theme = 1; // theme numero 1 par defaut 
                        $result = $newArticle->getArticleByIdTheme();
                    }

                    showArticle($result);
                    ?>

<!-- fonction d affichage -->
<?php
function showArticle($result)
{
    // Parcours des articles et génération du code HTML pour chaque article
    foreach ($result as $objetA) {
        // Utilisation d'un bloc PHP séparé dans l'HTML pour afficher dynamiquement les données
        echo '
     
           <article class="max-w-sm bg-white rounded-lg shadow-md overflow-hidden mb-8">
             <form action="article.php" method="post">
              <button name="btnShowArticle">
                <div class="relative">
                        <img alt="Article image" class="w-full h-48 object-cover" height="200" src="https://storage.googleapis.com/a1aa/image/1w7siogdbFZHCdkQTsJJ3c15b4xDwJsX8QyhqYW2s4DhbtAF.jpg" width="400"/>
                        <div class="absolute top-0 left-0 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-br-lg">
                            ' . $objetA->title_theme . '
                        </div>
                    </div>

                    <div class="p-4">
                        <div class="flex items-center mb-2">
                            <img alt="Profile picture of the author" class="w-10 h-10 rounded-full mr-3" height="40" src="https://storage.googleapis.com/a1aa/image/9iczK958z0LHApmuryvtgVI5hTtjwPFmfQJoQAqOffRJFsGoA.jpg" width="40"/>
                            <div>
                                <h2 class="text-lg font-semibold">
                                    ' . $objetA->title . '
                                </h2>
                                <p class="text-gray-500 text-sm">
                                    by ' . $objetA->nom_user . ' ' . $objetA->prenom_user . '
                                </p>
                            </div>
                        </div>

                        <p class="text-gray-600 text-sm mb-4">
                            ' . substr($objetA->content, 0, 150) . '...
                        </p>

                        <div class="flex items-center justify-between text-gray-500 text-xs mb-4">
                            <span>' . date('F j, Y', strtotime($objetA->created_at)) . '</span>
                            <div class="flex space-x-4">
                                <div class="flex items-center space-x-1">
                                    <i class="far fa-heart"></i>
                                    <span>0</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <i class="far fa-comment"></i>
                                    <span>0</span>
                                </div>
                                <i class="fas fa-ellipsis-h"></i>
                            </div>
                        </div>

                        <div class="flex space-x-2">
                            <span class="bg-blue-200 text-blue-800 text-xs font-semibold px-2 py-1 rounded">
                                Travel
                            </span>
                            <span class="bg-green-200 text-green-800 text-xs font-semibold px-2 py-1 rounded">
                                Adventure
                            </span>
                            <span class="bg-yellow-200 text-yellow-800 text-xs font-semibold px-2 py-1 rounded">
                                Photography
                            </span>
                        </div>
                    </div>
                       </button>
                </form>
                </article>
         ';
    }
}
?>


                </div>
                <div class="mt-8 flex justify-center">
                    <nav class="inline-flex space-x-2">
                        <a class="px-4 py-2 bg-indigo-900 text-white rounded-lg" href="#">
                            1
                        </a>
                        <a class="px-4 py-2 bg-white text-gray-600 rounded-lg" href="#">
                            2
                        </a>
                        <a class="px-4 py-2 bg-white text-gray-600 rounded-lg" href="#">
                            3
                        </a>
                        <a class="px-4 py-2 bg-white text-gray-600 rounded-lg" href="#">
                            4
                        </a>
                    </nav>
                </div>
            </section>
        </div>
    </main>
    <footer class="bg-gray-200 py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap -mx-4">
                <div class="w-full md:w-1/4 px-4 mb-8 md:mb-0">
                    <div class="text-2xl font-bold text-indigo-900 mb-4">
                        Sada.
                    </div>
                    <p class="text-gray-600">
                        © 2018 Energetic Themes
                    </p>
                </div>
                <div class="w-full md:w-1/4 px-4 mb-8 md:mb-0">
                    <h2 class="text-xl font-bold mb-4">
                        About us
                    </h2>
                    <ul class="space-y-2">
                        <li>
                            <a class="text-gray-600 hover:text-indigo-900" href="#">
                                Aenean mattis
                            </a>
                        </li>
                        <li>
                            <a class="text-gray-600 hover:text-indigo-900" href="#">
                                Vestibulum ante
                            </a>
                        </li>
                        <li>
                            <a class="text-gray-600 hover:text-indigo-900" href="#">
                                Sapien etiam
                            </a>
                        </li>
                        <li>
                            <a class="text-gray-600 hover:text-indigo-900" href="#">
                                Morbi eget leo
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="w-full md:w-1/4 px-4 mb-8 md:mb-0">
                    <h2 class="text-xl font-bold mb-4">
                        Product
                    </h2>
                    <ul class="space-y-2">
                        <li>
                            <a class="text-gray-600 hover:text-indigo-900" href="#">
                                Vestibulum diam
                            </a>
                        </li>
                        <li>
                            <a class="text-gray-600 hover:text-indigo-900" href="#">
                                Phasellus sapien eros
                            </a>
                        </li>
                        <li>
                            <a class="text-gray-600 hover:text-indigo-900" href="#">
                                Finibus bibendum nulla
                            </a>
                        </li>
                        <li>
                            <a class="text-gray-600 hover:text-indigo-900" href="#">
                                Duis tristique, turpis
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="w-full md:w-1/4 px-4">
                    <h2 class="text-xl font-bold mb-4">
                        Contact us
                    </h2>
                    <p class="text-gray-600 mb-2">
                        Hello@sadaweb.com
                    </p>
                    <p class="text-gray-600 mb-4">
                        + 08455-3354-202
                    </p>
                    <div class="flex space-x-4">
                        <a class="text-gray-600 hover:text-indigo-900" href="#">
                            <i class="fab fa-facebook-f">
                            </i>
                        </a>
                        <a class="text-gray-600 hover:text-indigo-900" href="#">
                            <i class="fab fa-twitter">
                            </i>
                        </a>
                        <a class="text-gray-600 hover:text-indigo-900" href="#">
                            <i class="fab fa-instagram">
                            </i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>