<?php
ob_start();
session_start();
require_once 'User.php';
require("../../sweetAlert/sweetAlert.php"); 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscription</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
  <div class="flex flex-col justify-center items-center w-full h-[100vh] bg-[#282D2D] px-5">
    <div class="flex flex-col items-end justify-start overflow-hidden mb-2 xl:max-w-3xl w-full">
    <a href="../../home.php" class="flex items-center space-x-4 text-white">
             <i class="fas fa-home"></i>
            <span>Accueil</span>
        </a> 

    </div>
   
    <div class="w-full p-3 sm:p-6 rounded-md">
  <h1 class="text-center text-lg sm:text-xl font-semibold text-white">
    Inscrivez-vous pour un compte gratuit
  </h1>
  <div class="w-full mt-4">
    <form action="" method="post">
      <div class="mx-auto max-w-sm flex flex-col gap-3">
        <div class="flex items-center justify-between gap-3">
          <label for="nom" class="text-white text-sm w-1/3">Nom :</label>
          <input name="nom" class="w-2/3 px-3 py-2 rounded-lg font-medium border border-gray-300 placeholder-gray-400 text-xs focus:outline-none focus:border focus:border-gray-400" type="text" placeholder="Votre nom" required />
        </div>
        <div class="flex items-center justify-between gap-3">
          <label for="prenom" class="text-white text-sm w-1/3">Prénom :</label>
          <input name="prenom" class="w-2/3 px-3 py-2 rounded-lg font-medium border border-gray-300 placeholder-gray-400 text-xs focus:outline-none focus:border focus:border-gray-400" type="text" placeholder="Prénom" />
       </div>
        <div class="flex items-center justify-between gap-3">
          <label for="email" class="text-white text-sm w-1/3">Email :</label>
          <input name="email" class="w-2/3 px-3 py-2 rounded-lg font-medium border border-gray-300 placeholder-gray-400 text-xs focus:outline-none focus:border focus:border-gray-400" type="email" placeholder="Votre adresse email" required />
        </div>
        <div class="flex items-center justify-between gap-3">
          <label for="password" class="text-white text-sm w-1/3">Mot de passe :</label>
          <input name="password" class="w-2/3 px-3 py-2 rounded-lg font-medium border border-gray-300 placeholder-gray-400 text-xs focus:outline-none focus:border focus:border-gray-400" type="password" placeholder="Votre mot de passe" required />
        </div>
        <div class="flex items-center justify-between gap-3">
          <label for="password1" class="text-white text-sm w-1/3">Confirmez :</label>
          <input name="password1" class="w-2/3 px-3 py-2 rounded-lg font-medium border border-gray-300 placeholder-gray-400 text-xs focus:outline-none focus:border focus:border-gray-400" type="password" placeholder="Confirmez le mot de passe" required />
        </div>
        <button type="submit" name="inscrir" class="mt-4 tracking-wide font-semibold bg-[#FEA116] text-gray-100 w-full py-2 rounded-lg hover:bg-[#E9522C]/90 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none">
          <svg class="w-4 h-4 -ml-2" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
            <circle cx="8.5" cy="7" r="4" />
            <path d="M20 8v6M23 11h-6" />
          </svg>
          <span class="ml-2 text-xs">S'inscrire</span>
        </button>
        <p class="mt-4 text-xs text-gray-600 text-center">
          <a href="login.php">
            <span class="text-[#FEA116] font-semibold">Se connecter</span>
          </a>
        </p>
      </div>
    </form>
  </div>
</div>





  </div>
<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["inscrir"])) {


    // Récupération des données du formulaire
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $password1 = $_POST["password1"];
    $id_role =2 ;  // Rôle client

  
    if ($password !== $password1) {
            $_SESSION['msgSweetAlert']= [
              'title' =>'Avertissment'  ,
              'text' => 'les mots de passe ne sont pas identiques ',
              'status' => 'error'
            ] ;
              sweetAlert('login.php'); 
            exit; 
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $newUser = new User($nom, $prenom, $email, $hashed_password, $id_role);
        $result = User::registreUser($newUser);
        // echo "The ID of the new user is: " . $_SESSION['id_user'];
         header("Location: ../../index.php");
        if ($result) {
            // Démarrage de la session
            session_regenerate_id();
            $_SESSION['login'] = TRUE;
            $_SESSION['nom'] = $nom;
            $_SESSION['email'] = $email;
            $_SESSION['role'] = "client";
            $_SESSION['id_role'] = "2";
            $_SESSION['id_user'] = $newUser->lastInsertId();
        } else {
              $_SESSION['msgSweetAlert']= [
                'title' =>'Avertissment'  ,
                'text' => 'Erreur d enregistrement ',
                'status' => 'error'
               ] ;
                sweetAlert('register.php'); 
               exit; 
        }
    }
}
?>

