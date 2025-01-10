<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/locationVoiture/autoload.php';

use Models\Article;
use Models\Theme;
use Models\Tag;
use Models\ArticleTags;
use Models\Comment;
use Models\DatabaseManager;

$_SESSION['id_user'] = 5;
$id_user = $_SESSION['id_user'];


$dbManager = new DatabaseManager();


if (isset($_POST["addComment"])) {
    $newComment = new Comment($dbManager, 0, $_POST['commentaire'], intval($_POST['id_article']), intval($id_user));
    $newComment->add();
}
if (isset($_POST["deleteComment"])) {
    $newComment = new Comment($dbManager, intval($_POST['id_comment']));
    $newComment->delete();
}
?>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Sada Blog Post</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100">
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
                    <input type="text" class="border border-gray-300 rounded-lg py-2 px-4 pl-10 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Search...">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
                </div>
            </nav>
        </div>
    </header>
    <main class="container mx-auto px-4 py-8 relative">
    <form method="POST" action="">
        <?php
        if ($_SERVER["METHOD_REQUEST"] = "POST"   && (isset($_POST["id_article"]))) :
            $id_article = $_POST["id_article"];
            $newArticle = new Article($dbManager, $id_article);
            $objet = $newArticle->getDetailArticle();
            //SELECT ar.* , th.name AS title_theme , u.nom  AS nom_user  , u.prenom AS prenom_user  
        ?>
            <div class="bg-white shadow-lg rounded-lg overflow-hidden relative z-10">
                <img alt="A person sitting on a couch in a well-decorated living room with large windows, plants, and artwork" class="w-full h-96 object-cover" height="600" src="https://placehold.co/1200x600" width="1200" />
                <div class="p-8">
                    <div class="text-gray-500 text-sm mb-4"><?= $objet->created_at ?> - <?= $objet->title_theme ?></div>
                    <h1 class="text-3xl font-bold text-indigo-900 mb-4"><?= $objet->title ?></h1>
                    <p class="text-gray-700 mb-4">
                        <?= $objet->content ?>
                    </p>

                    <blockquote class="border-l-4 border-indigo-600 pl-4 italic text-gray-700 mb-4">
                        “L'auteur de l'article est : ” <?= $objet->nom_user ?> <?= $objet->prenom_user ?>
                    </blockquote>
                    <p class="text-gray-700 mb-4">
                        Suspendisse viverra massa eget nibh ultricies mollis. Donec sed lorem tincidunt, ultricies ligula ut, euismod sem. Mauris nec tincidunt diam. Donec varius magna vitae velit consectetur difficultat. Sed rutrum aliquet ligula. Cras non pellentesque nisi, id laoreet nibh. Aliquam in ante elit. Praesent blandit nibh ac justo auctor pretium. Maecenas mauris metus, vulputate ac volutpat sit amet, facilisis quis odio. Nam ut commodo neque.
                    </p>
                    <div class="flex space-x-2 mb-8">
                        <?php
                        $newtag = new ArticleTags($dbManager, $objet->id_article);
                        $result = $newtag->getTagsByArticle();
                        foreach ($result as $Objet_tag) {
                            echo '<span class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full">' . $Objet_tag->name . '</span>';
                        }
                        ?>
                    </div>
                    <div class="flex justify-between items-center border-t border-gray-200 pt-4">
                        <a class="text-indigo-600 hover:text-indigo-900 flex items-center" href="#"><i class="fas fa-arrow-left mr-2"></i>Sellentesque tristique neque</a>
                        <a class="text-indigo-600 hover:text-indigo-900 flex items-center" href="#">Aliquam lobortis urna libero<i class="fas fa-arrow-right ml-2"></i></a>
                    </div>
                </div>
            </div>
      
            <div class="bg-white shadow-lg rounded-lg mt-8 p-8 relative z-10">
                <h2 class="text-2xl font-bold text-indigo-900 mb-4">Leave a comment</h2>
                <div class="mb-4">
                        <input type=hidden name="id_article" value="<?= htmlspecialchars($objet->id_article) ?>">
                        <textarea name="commentaire" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Write a comment..." rows="3"></textarea>
                        <div class="flex justify-between items-center mt-2">
                            <button name="addComment" class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                                Post comment
                            </button>
                            <div class="flex space-x-2 text-gray-500">
                                <i class="fas fa-paperclip">
                                </i>
                                <i class="fas fa-map-marker-alt">
                                </i>
                            </div>
                        </div>
                   
                </div>
                <!-- commentaires des users -->
                <?php
                $newComment = new Comment($dbManager);
                $newComment->id_article = $objet->id_article;
                $result = $newComment->getCommentByArticle();
                foreach ($result as $objet_Cmt):
                ?>
                    <div class="bg-gray-50 p-4 m-8 rounded-lg shadow-sm">
                        <div class="flex items-center mb-2">
                            <img alt="Profile picture of the commenter" class="w-10 h-10 rounded-full mr-3" height="40" src="https://storage.googleapis.com/a1aa/image/1ZK6eQz7uGxKOahfeQHlR1zQxhXhr8QxTxrVwEFg60TCDUGoA.jpg" width="40" />
                            <div>
                                <p class="font-semibold">
                                    <?= $objet_Cmt->nom ?> <?= $objet_Cmt->prenom ?>
                                </p>
                                <p class="text-sm text-gray-500">
                                    <?= $objet_Cmt->created_at ?>
                                </p>
                            </div>
                            <?php if($id_user == $objet_Cmt->id_user) : ?>
                            <div class="ml-auto text-gray-500 cursor-pointer hover:text-red-500">
                                <input type="text" name="id_comment" value="<?= $objet_Cmt->id_comment ?>">
                                <button name="deleteComment"> <i class="fas fa-times"></i></button>
                            </div>
                            <?php endif ;?>
                        </div>
                        <p class="text-gray-700 mb-2">
                            <?= $objet_Cmt->content ?>
                        </p>
                        <div class="flex items-center text-gray-500">
                            <i class="fas fa-heart mr-1">
                            </i>
                            <span class="mr-4">
                                11 Likes
                            </span>
                            <i class="fas fa-reply mr-1">
                            </i>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        </form>
    </main>
    <footer class="bg-white py-8 mt-8">
        <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <div class="text-2xl font-bold text-indigo-900 mb-4">Sada.</div>
                <p class="text-gray-500">© 2018 Energetic Themes</p>
            </div>
            <div>
                <h3 class="text-lg font-bold text-indigo-900 mb-4">About us</h3>
                <ul class="text-gray-700 space-y-2">
                    <li><a class="hover:text-indigo-600" href="#">Aenean mattis</a></li>
                    <li><a class="hover:text-indigo-600" href="#">Vestibulum ante</a></li>
                    <li><a class="hover:text-indigo-600" href="#">Sapien etiam</a></li>
                    <li><a class="hover:text-indigo-600" href="#">Morbi eget leo</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-bold text-indigo-900 mb-4">Product</h3>
                <ul class="text-gray-700 space-y-2">
                    <li><a class="hover:text-indigo-600" href="#">Vestibulum diam</a></li>
                    <li><a class="hover:text-indigo-600" href="#">Phaesolus sapien eros</a></li>
                    <li><a class="hover:text-indigo-600" href="#">Finibus bibendum nulla</a></li>
                    <li><a class="hover:text-indigo-600" href="#">Duis tristique, turpis</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-bold text-indigo-900 mb-4">Contact us</h3>
                <ul class="text-gray-700 space-y-2">
                    <li><a class="hover:text-indigo-600" href="mailto:hello@sadaweb.com">Hello@sadaweb.com</a></li>
                    <li><a class="hover:text-indigo-600" href="tel:+084553564202">+08455-3564-202</a></li>
                    <li class="flex space-x-4">
                        <a class="hover:text-indigo-600" href="#"><i class="fab fa-facebook-f"></i></a>
                        <a class="hover:text-indigo-600" href="#"><i class="fab fa-instagram"></i></a>
                        <a class="hover:text-indigo-600" href="#"><i class="fab fa-behance"></i></a>
                        <a class="hover:text-indigo-600" href="#"><i class="fab fa-twitter"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </footer>
</body>

</html>