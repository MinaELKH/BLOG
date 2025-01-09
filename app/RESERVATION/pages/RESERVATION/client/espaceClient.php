<?php 
use  ModelsReservation\Avis ; 
use  ModelsReservation\AfficheReservation ; 
use  ModelsReservation\Reservation ; 
use Models\Database ;
use Models\DatabaseManager ;

ob_start();
session_start();

$title = "Gestion des réservations";

// require __DIR__ . "/../backend/AfficheReservation.php";
// require __DIR__ . "/../backend/Reservation.php";
// require __DIR__ . "/../backend/Avis.php";
// require_once __DIR__ . '/../../includ/DB.php';
// require_once __DIR__ . '/../../includ/DatabaseManager.php';
?>


<script>
   
    function submitOnEnter(event, form) {
        if (event.key === "Enter" ) {
            event.preventDefault();
            form.submit();
        }
    }
  // code pour les etoiles  : 
  //src : youtube https://www.youtube.com/watch?v=Djg-Fm-Pkgc
  //git  : https://github.com/NouvelleTechno/Stars-Rating/
  window.onload = () => {
    // On récupère tous les conteneurs de réservation
    const reservationContainers = document.querySelectorAll(".reservation");
    reservationContainers.forEach(container => {
        // On récupère les étoiles et l'input spécifique à ce conteneur
        const stars = container.querySelectorAll(".la-star");
        const note = container.querySelector("#note");


        let noteValue = parseInt(note.value);
        noteValue = isNaN(noteValue) ? 0 : noteValue  // si la val not number il faut donner 0 --si la reservtaion ne contient pas d etoile

        resetStars(stars, noteValue); 


        // On boucle sur les étoiles pour leur ajouter des écouteurs d'évènements
        stars.forEach(star => {
            // Écouteur pour le survol
            star.addEventListener("mouseover", function () {
                resetStars(stars, note.value);
                this.style.color = "gold";
                this.classList.add("las");
                this.classList.remove("lar");

                // Étoiles précédentes
                let previousStar = this.previousElementSibling;
                while (previousStar) {
                    previousStar.style.color = "gold";
                    previousStar.classList.add("las");
                    previousStar.classList.remove("lar");
                    previousStar = previousStar.previousElementSibling;
                }
            });

            // Écouteur pour le clic
            star.addEventListener("click", function () {
                note.value = this.dataset.value;
            });

            // Écouteur pour le retrait de la souris
            star.addEventListener("mouseout", function () {
                resetStars(stars, note.value);
            });
        });

        // Fonction pour réinitialiser les étoiles
        function resetStars(stars, note=0) {
            //alert(note) ; 
            stars.forEach(star => {
                if (star.dataset.value > note) {
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

<?php


$dbManager = new DatabaseManager(Database::getInstance()->getConnection());

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["action"])) {
        $action = $_POST["action"];
        $id_reservation = intval($_POST["id_reservation"] ?? 0);

        if ($action === "archive") {
            $reservation = new Reservation($dbManager, $id_reservation);
            $reservation->archiveReservation();
        } elseif ($action === "ajouterAvis") {
            $comment = $_POST["comment"] ;
            $etoile = intval($_POST["note"]);
            $id_avis=intval($_POST['ajouterAvis']);
            $avis = new Avis($dbManager, $id_avis ,  $id_reservation, $comment, $etoile); // 3 étoiles par défaut
            if($id_avis > 0){ // je recupere l id_avis et on modif
              $avis->editerAvis();
           } else { // sinon c est un new avis
              $avis->ajouterAvis();
           }
        }
    }
}

$afficheReservation = new AfficheReservation($dbManager);
$id_user =  $_SESSION['id_user'] ;

$result = $afficheReservation->getAllReserv_Of_User($id_user);
// var_dump($id_user) ;
// die() ;
foreach ($result as $objet) :

    echo '<div class=" reservation space-y-6 my-2.5">
        <form action="" method="post">
            <div class="grid grid-cols-5 items-center bg-white shadow-lg rounded-lg overflow-hidden p-2">
                <input type="hidden" name="id_reservation" value="' . $objet->id_reservation . '">
                <input type="hidden" name="action" value="">
                <div class="col-span-1">
                    <img src="' . $objet->photo . '" alt="Voiture réservée" class="w-full h-32 object-cover rounded-lg" />
                </div>
                <div class="col-span-2 px-4">
                    <div class="flex justify-between items-center">
                        <h4 class="text-lg font-bold text-gray-800">' . $objet->nom_vehicule . ' ' . $objet->model . ' ' . $objet->marque . '</h4>
                        <p class="text-indigo-500 font-medium">Prix : ' . $objet->prix . '</p>
                    </div>
                    <p class="text-sm text-gray-600">
                        Date de réservation : ' . $objet->date_reservation . ' 
                    </p>
                     <p class="text-sm text-gray-600">
                       Date de début : ' . $objet->date_debut . ' 
                    </p>
                     <p class="text-sm text-gray-600">
                      Date de fin : ' . $objet->date_fin . '
                    </p>
                    <p class="text-sm text-gray-700">
                        <span class="font-semibold">Statut :</span> ' . $objet->statut . '
                    </p>


                  <i class="fa-regular fa-pen-to-square"></i>
                        <button type="submit" class="hover:text-orange-600 transition" onclick="this.form.action.value=\'archive\'">
                             <i class="fas fa-trash"></i>
                        </button>
                </div>

                  <div class="col-span-2 px-4">
                         <div class="flex items-center">
                        <h4 class="text-sm font-semibold text-gray-500"> Votre Avis Nous interesse </h4>
                       
                          </div>
                    <textarea 
                        class="w-full mt-2 p-2 text-sm text-gray-500 bg-gray-100 rounded-md resize-none" 
                        name="comment"
                        placeholder="Laisser un commentaire..." 
                        rows="2"
                        onkeydown="submitOnEnter(event, this.form)"
                    > ' . $objet->description .'</textarea>
                        <!--star  note-->
                       

                        <div class="stars flex items-center py-2">
                            <i class="lar la-star" data-value="1"></i>
                            <i class="lar la-star" data-value="2"></i>
                            <i class="lar la-star" data-value="3"></i>
                            <i class="lar la-star" data-value="4"></i>
                            <i class="lar la-star" data-value="5"></i>
                            
                            <!-- Input caché pour la note -->
                            <input type="hidden" name="note" id="note"  value=" ' . $objet->etoiles . '">
                            
                            <!-- Conteneur pour le bouton et le texte -->
                            <div class="flex gap-4 mt-2 text-sm text-gray-500 ml-auto">
                                <button type="submit"  name="ajouterAvis"  value="'.$objet->id_avis.'" class="hover:text-orange-600 transition" onclick="this.form.action.value=\'ajouterAvis\'">
                                             
                                             Envoyer
                                </button>
                            </div>
                        </div> 
                    </div>
            </div>
        </form>
    </div>';
endforeach;
?>

<?php
$content = ob_get_clean();
include 'layout.php';
?>
