
<?php
ob_start();
session_start() ; 
require("../../sweetAlert/sweetAlert.php"); 

?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- sweet alert-->
</head>
<body>
  <div class="flex flex-col justify-center items-center w-full h-[100vh] bg-[#282D2D]  px-5">
    <div class="flex flex-col items-end justify-start overflow-hidden mb-2 xl:max-w-3xl w-full">   
       <a href="../frontend/home.php" class="flex items-center space-x-4 text-white">
             <i class="fas fa-home"></i>
            <span>Accueil</span>
        </a> </div>
    <div class="w-full p-5 sm:p-10 rounded-md">
      <h1 class="text-center text-xl sm:text-3xl font-semibold text-white">
        Connectez-vous à votre compte
      </h1>
      <div class="w-full mt-8">
        <form  action=""  method="post">
        <div class="mx-auto max-w-xs sm:max-w-md md:max-w-lg flex flex-col gap-4">
          <div>
            <label for="email" class="text-white">Email :</label>
            <input id="email" name="email"
              class="w-full px-5 py-3 rounded-lg font-medium border-2 border-transparent placeholder-gray-500 text-sm focus:outline-none focus:border-2 focus:outline"
              type="email"
              placeholder="Votre adresse email" />
          </div>
          <div>
            <label for="password" class="text-white">Mot de passe :</label>
            <input id="password" name="password"
              class="w-full px-5 py-3 rounded-lg font-medium border-2 border-transparent placeholder-gray-500 text-sm focus:outline-none focus:border-2 focus:outline"
              type="password"
              placeholder="Votre mot de passe" />
          </div>
          <button type="submit" name="connecter" class="mt-5 tracking-wide font-semibold bg-[#FEA116] text-gray-100 w-full py-4 rounded-lg hover:bg-[#E9522C]/90 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none">
            <svg class="w-6 h-6 -ml-2" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
              <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
              <circle cx="8.5" cy="7" r="4" />
              <path d="M20 8v6M23 11h-6" />
            </svg>
            <span class="ml-3">Se connecter</span>
          </button>
          <p class="mt-6 text-xs text-gray-600 text-center">
            Pas encore de compte ? 
            <a href="register.php">
              <span class="text-[#FEA116] font-semibold">Inscrivez-vous</span>
            </a>
          </p>
        </div>
</form>
      </div>
    </div>
  </div>

 

  <?php

require_once 'User.php'; // Inclut la classe User


if (isset($_POST["connecter"]) && !empty($_POST["email"]) && !empty($_POST["password"])) {
    $email = $_POST["email"];
    $pwd = $_POST["password"];
    $result =User::login($email ,$pwd)   ;// l password recupere par la requette sq
    if ( $result['success']) {
      $user = $result['user'];
   //   print_r($user);
          //client
          
            session_regenerate_id();
            $_SESSION['login'] = TRUE;
            $_SESSION['nom'] = $user->nom ."  ". $user->prenom;    
            $_SESSION['id_user'] = $user->id_user; 
            $_SESSION['id_role'] = $user->id_role; 
           // echo 'Bienvenue  ' . $_SESSION['id_role'];
            // echo "<br><p class='text-red-500 text-center'> role est" . $user->id_role ."</p>";
            //       var_dump($_SESSION['id_role'] );
            //       exit ;
            
         
                if($user->id_role==1) //admin
                {
                  echo "<p class='text-red-500 text-center'>admin.</p>";
                  $_SESSION['role'] ="admin" ;
                  header("location:../frontend/Dashboard.php") ;
                  exit ;
                } else if ($user->id_role==2) {
                  $_SESSION['role'] ="client" ;
                  header("location:../frontend/home.php") ;
                  exit ;
                }
        
         
              
                } else{
                  $_SESSION['msgSweetAlert']= [
                    'title' =>'Avertissment'  ,
                    'text' => 'Erreur d authentification ',
                    'status' => 'error'
               ] ;
               sweetAlert('login.php'); 
               exit; 
                 }

}
?>




</body>
</html>
