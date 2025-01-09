<?php
ob_start();
session_start();
require("../../sweetAlert/sweetAlert.php");
use  ModelsReservation\classe_Avis ; 
use Models\Database ;
use Models\DatabaseManager ;

// require_once __DIR__ . "/../backend/classe_Avis.php";
// require_once __DIR__ . '/../../includ/DB.php';
// require_once __DIR__ . '/../../includ/DatabaseManager.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head data-pg-collapsed>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Design of the Week Template 12 - Pinegrow Web Editor</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="js/main.js"  defer></script>
<!-- les etoiles -->  <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

        <link href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css" rel="stylesheet">

        <link href="PrimeDrive_TW/PrimeDrive_TW/tailwind_theme/tailwind.css" rel="stylesheet" type="text/css">
        <script>/* Pinegrow Interactions, do not remove */ (function(){try{if(!document.documentElement.hasAttribute('data-pg-ia-disabled')) { window.pgia_small_mq=typeof pgia_small_mq=='string'?pgia_small_mq:'(max-width:767px)';window.pgia_large_mq=typeof pgia_large_mq=='string'?pgia_large_mq:'(min-width:768px)';var style = document.createElement('style');var pgcss='html:not(.pg-ia-no-preview) [data-pg-ia-hide=""] {opacity:0;visibility:hidden;}html:not(.pg-ia-no-preview) [data-pg-ia-show=""] {opacity:1;visibility:visible;display:block;}';if(document.documentElement.hasAttribute('data-pg-id') && document.documentElement.hasAttribute('data-pg-mobile')) {pgia_small_mq='(min-width:0)';pgia_large_mq='(min-width:99999px)'} pgcss+='@media ' + pgia_small_mq + '{ html:not(.pg-ia-no-preview) [data-pg-ia-hide="mobile"] {opacity:0;visibility:hidden;}html:not(.pg-ia-no-preview) [data-pg-ia-show="mobile"] {opacity:1;visibility:visible;display:block;}}';pgcss+='@media ' + pgia_large_mq + '{html:not(.pg-ia-no-preview) [data-pg-ia-hide="desktop"] {opacity:0;visibility:hidden;}html:not(.pg-ia-no-preview) [data-pg-ia-show="desktop"] {opacity:1;visibility:visible;display:block;}}';style.innerHTML=pgcss;document.querySelector('head').appendChild(style);}}catch(e){console&&console.log(e);}})()</script>
    </head>
    <body class="font-serif text-gray-500"> 
        <header class="bg-gray-900 bg-opacity-95 py-2">
            <div class="container mx-auto relative"> 
                <nav class="flex flex-wrap items-center px-4"> 
                    <a href="home.php" class="font-bold font-sans hover:text-opacity-75 inline-flex items-center leading-none mr-4 space-x-1 text-primary-500 text-xl uppercase"><svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="2.5em" xml:space="preserve" fill="currentColor" viewBox="0 0 100 100" height="2.5em">
                            <path d="M38.333 80a11.571 11.571 0 0 1-7.646-2.883A11.724 11.724 0 0 1 26.834 70H10V46.667L43.333 40l20-20H90v26.667H43.995l-27.328 5.465v11.2h11.166a11.787 11.787 0 0 1 4.212-4.807 11.563 11.563 0 0 1 12.577 0 11.789 11.789 0 0 1 4.213 4.807h7.833V70h-6.837a11.719 11.719 0 0 1-3.853 7.117A11.571 11.571 0 0 1 38.333 80Zm0-16.667a5 5 0 1 0 5 5 5.006 5.006 0 0 0-5.001-5Zm27.761-36.666L52.762 40h30.571V26.667Z"></path>
                            <path d="M56.667 63.333h-7.833a11.6 11.6 0 0 0-21 0H16.667v-11.2l27.328-5.465h12.672Z" opacity="0.2"></path>
                            <path d="M90 63.333H80v-10h-6.667v10h-10V70h10v10H80V70h10Z"></path>
                            <path d="M52.762 40h30.571V26.667H66.094Z" opacity="0.2"></path>
                        </svg><span>Prime Drive</span> </a> 
                    <button class="hover:bg-primary-500 hover:text-white ml-auto px-3 py-2 rounded text-white lg:hidden" data-name="nav-toggler" data-pg-ia='{"l":[{"name":"NabMenuToggler","trg":"click","a":{"l":[{"t":"^nav|[data-name=nav-menu]","l":[{"t":"set","p":0,"d":0,"l":{"class.remove":"hidden"}}]},{"t":"#gt# span:nth-of-type(1)","l":[{"t":"tween","p":0,"d":0.2,"l":{"rotationZ":45,"yPercent":300}}]},{"t":"#gt# span:nth-of-type(2)","l":[{"t":"tween","p":0,"d":0.2,"l":{"autoAlpha":0}}]},{"t":"#gt# span:nth-of-type(3)","l":[{"t":"tween","p":0,"d":0.2,"l":{"rotationZ":-45,"yPercent":-300}}]}]},"pdef":"true","trev":"true"}]}' data-pg-ia-apply="$nav [data-name=nav-toggler]"> 
                        <span class="block border-b-2 border-current my-1 w-6"></span> 
                        <span class="block border-b-2 border-current my-1 w-6"></span> 
                        <span class="block border-b-2 border-current my-1 w-6"></span> 
                    </button>                     
                    <div class="flex-1 hidden space-y-2 w-full lg:flex lg:items-center lg:space-x-4 lg:space-y-0 lg:w-auto" data-name="nav-menu"> 
                        <div class="flex flex-col mr-auto lg:flex-row"> 
                        <a href="home.php" class="hover:text-gray-400 lg:p-4 py-2 text-white">Acceuil</a>
                            <a href="#" class="hover:text-gray-400 lg:p-4 py-2 text-white">Offre</a>
                            <a href="#" class="hover:text-gray-400 lg:p-4 py-2 text-white">Locations</a>
                            <a href="#" class="hover:text-gray-400 lg:p-4 py-2 text-white">Support</a> 
                        </div>
                 <?php
                 if(isset($_SESSION['id_role']) &&  $_SESSION['id_role']==2){
                   echo  "   <a href='#' class='flex items-center hover:text-[#FEA116] text-3xl'>
                            <i class='fa-solid fa-user-tie'></i>
                            </a>
                        " ; 
                  } else {
                    echo  '<div class="flex-wrap inline-flex items-center py-1 space-x-2"> 
                                <a href="../login/login.php" class="border border-primary-500 hover:bg-primary-500 hover:text-white inline-block px-6 py-2 text-primary-500">
                                Log In</a>
                                <a href="../login/register.php" class="bg-primary-500 border border-primary-500 hover:bg-primary-600 inline-block px-6 py-2 text-white">
                                Sign Up</a> 
                            </div>
                         ' ; 
                  }
                 ?>
                    </div>                     
                </nav>                 
            </div>
        </header>
<main>
<script>
window.onload = () => {
    // On récupère tous les conteneurs d'avis
    const AvisContainers = document.querySelectorAll(".Avis");
    AvisContainers.forEach(container => {
        // On récupère les étoiles et l'input spécifique à ce conteneur
        const stars = container.querySelectorAll(".la-star");
        const note = container.querySelector(".note");

        let noteValue = parseInt(note.value);
        noteValue = isNaN(noteValue) ? 0 : noteValue;  // Si la valeur n'est pas un nombre, donner 0

        resetStars(stars, noteValue);

        // Fonction pour réinitialiser les étoiles
        function resetStars(stars, note = 0) {
            stars.forEach(star => {
                if (parseInt(star.dataset.value) > note) {
                    star.style.color = "gray";
                    star.classList.add("lar");
                    star.classList.remove("las");
                } else {
                    star.style.color = "gold";
                    star.classList.add("las");
                    star.classList.remove("lar");
                }
            });
        }
    });
};
</script>
<div class="container mx-auto px-4 lg:mt-10"> 
<div class="-mx-4 flex flex-wrap items-center mb-6"> 
    <div class="px-4 w-full md:w-10/12"> 
        <h2 class="font-medium mb-1 text-primary-500 text-xl">Ce que disent nos clients</h2>
        <h3 class="capitalize font-bold mb-4 text-4xl text-gray-900">Découvrez les avis passionnants de ceux qui ont vécu l'expérience</h3>
        <div class="bg-primary-500 mb-6 pb-1 w-2/12"></div>                             
    </div>                         
</div>
<div>
    
<?php
// Récupération des avis
if (isset($_POST["AfficherAvis"])) {
    $id_vehicule = $_POST['AfficherAvis']; 
    $dbManager = new DatabaseManager();
    $newListAvis = new Avis($dbManager);
    $result = $newListAvis->getById($id_vehicule);
    //  var_dump($result) ;
    //  die() ;
    foreach ($result as $objet) {
        echo '
        <div class="Avis bg-white p-4 my-2.5 rounded-lg shadow-md max-w-xl w-full">
            <div class="flex items-start space-x-4">
                <img 
                    alt="Profile picture of the user" 
                    class="w-12 h-12 rounded-full" 
                    src="https://storage.googleapis.com/a1aa/image/sFObDJfTuDSnJy9Jhp2BXWDeq81rs24nEad8j6diwCJnjHCUA.jpg" 
                    width="50" 
                    height="50"
                />
                <div class="flex-1">
                    <div class="flex items-center justify-between">
                       
                            <h4 class="font-semibold">
                                '.$objet->nom.' '.$objet->prenom.'
                            </h4>
                            <p class="text-sm text-gray-500">
                                '.$objet->date_avis.'
                            </p>
                        
                        <div class="text-gray-500">
                            <i class="fas fa-ellipsis-h"></i>
                        </div>
                    </div>
                    <p class="mt-2 text-gray-700 ml-5">
                        '.$objet->description.'
                    </p>
                    <div class="flex items-center  space-x-4 text-gray-500">
                        <div class="stars flex items-center py-2">
                            <i class="lar la-star" data-value="1"></i>
                            <i class="lar la-star" data-value="2"></i>
                            <i class="lar la-star" data-value="3"></i>
                            <i class="lar la-star" data-value="4"></i>
                            <i class="lar la-star" data-value="5"></i>
                            
                            <!-- Input caché pour la note -->
                            <input type="hidden" class="note" value="' . $objet->etoiles . '">
                        </div> 
                    </div>
                </div>
            </div>
        </div>';
    }
    exit; 
}
?>
</div>
</div>
</main>

</body>
</html>
