<?php



function sweetAlert($redirectUrl) {

  if (isset($_SESSION['msgSweetAlert'])) {
      $titre = $_SESSION['msgSweetAlert']['title'];
      $text = $_SESSION['msgSweetAlert']['text'];
      $status = $_SESSION['msgSweetAlert']['status'];

      echo "<script>
          document.addEventListener('DOMContentLoaded', function() {
              Swal.fire({
                  title: '".($status === "success" ? "Succès" : "Erreur")."',
                  text: '$text',
                  icon: '$status',
                  showConfirmButton: false,
                  timer: 5000 // 2000 milliseconds = 2 seconds
              }).then(() => {
                  window.location.href = '$redirectUrl'; // Redirect after alert
              });
          });
      </script>";

      unset($_SESSION['msgSweetAlert']); // Clear the message after displaying
  }
}
//  function sweetAlertDelete( $message){
//  echo " <script> Swal.fire({
//     title: 'Êtes-vous sûr ?',
//     text: $message,
//     icon: 'warning',
//     showCancelButton: true,
//     confirmButtonColor: '#3085d6',
//     cancelButtonColor: '#d33',
//     confirmButtonText: 'Oui, supprimer !',
//     cancelButtonText: 'Annuler'
//   }).then((result) => {
//     if (result.isConfirmed) {
//       Swal.fire(
//         'Supprimé !',
//         'L\'élément a été supprimé avec succès.',
//         'success'
//       );
//       // Ajoutez ici la logique pour effectuer la suppression, par exemple :
//       // window.location.href = 'delete.php?id=1';
//     }
//   }); </script>"  ; }
?>