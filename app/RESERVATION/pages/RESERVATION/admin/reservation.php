                                                                                                                                                                                                        <?php
ob_start();
session_start() ;
if ($_SESSION['id_role'] != 1 ) { // client ou visiteur
    header("location: erreur.php");
    exit;
} else if ( $_SESSION['id_role'] == 1) { // admin ou superAdmin
    $id_user = $_SESSION['id_user'];
}

$title = "Gestion des réservations";
require __DIR__ . "/../backend/classe_Vehicule.php";
require __DIR__ . "/../backend/classe_Categorie.php";
require __DIR__ . "/../backend/classe_Reservation.php";
require __DIR__ . "/../backend/classe_client.php";
require_once __DIR__ . '/../../includ/DB.php';
require_once __DIR__ . '/../../includ/DatabaseManager.php';

$dbManager = new DatabaseManager(Database::getInstance()->getConnection());

if (isset($_POST["archive"])) {
    $id_reservation = intval($_POST["archive"]);
    $reservation = new Reservation($dbManager , $id_reservation);
    $reservation->archiveReservation();
}

if (isset($_POST["changeStatut"])) {
    $id_reservation = intval($_POST["id_reservation"]);
    $newStatut = $_POST["changeStatut"];
    $reservation = new Reservation($dbManager ,$id_reservation );
    $result = $reservation->changeStatut( $newStatut);
}

if (isset($_POST["changeVehicule"])) {
    $id_reservation = intval($_POST["id_reservation"]);
    $newIdVehicule = $_POST["changeVehicule"];
    $reservation = new Reservation($dbManager);
    $result = $reservation->changeVehicule($id_reservation, $newIdVehicule);
}

afficher($dbManager);

function afficher($dbManager)
{$reservations = (new Reservation($dbManager))->getAll();
    if (!empty($reservations)) {
        echo "<div class='listeTable'><table border='1'><thead>";
        echo "<tr>
                    <th>Réference</th>
                    <th>Véhicule</th>
                    <th>client</th>
                    <th>Date début</th>
                    <th>Date fin</th>
                    <th>Statut</th>
                    <th>Statut</th>
                    <th>Archive</th>
               </tr></thead><tbody>";

        foreach ($reservations as $objet) {
            $id = $objet->id_reservation;
            $veh = (new vehicule($dbManager ,$objet->id_vehicule))-> getAttributById(['nom' , 'marque' , 'model']);
            $client = (new client($dbManager ,$objet->id_user))-> getAttributById(['nom']);
            echo "<tr>
                <td>{$objet->id_reservation}</td>  
                <td> $veh->nom <br/> marq:$veh->marque   model:$veh->model </td>
                 <td>{$client->nom}</td>
                <td>{$objet->date_reservation}</td>
                <td>{$objet->date_debut}</td>
                <td>{$objet->date_fin}</td>

             <td>
            <form action='' method='post'>
                <input type='hidden' name='id_reservation' value='{$objet->id_reservation}'>
                <select name='changeStatut' onchange='this.form.submit()' class='w-full bg-gray-100 border border-gray-300 rounded-lg p-2 text-sm'>
                    <option value='en attente'" . ($objet->statut === 'en attente' ? ' selected' : '') . ">En attente</option>
                    <option value='confirmée'" . ($objet->statut === 'confirmée' ? ' selected' : '') . ">Confirmée</option>
                    <option value='annulée'" . ($objet->statut === 'annulée' ? ' selected' : '') . ">Annulée</option>
                </select>
            </form>
           </td>
           
                    <td class='flex align-center justify-center'>
                        <form action='' method='post'>
                            <input type='hidden' name='id_reservation' value='{$objet->id_reservation}'>
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
