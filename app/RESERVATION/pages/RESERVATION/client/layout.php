<?php //session_start();
// $_SESSION['id_role'] = 1 ;
// $_SESSION['role'] = 'admin' ;  
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Concevoir une application web de gestion d agence de voyage">
    <meta name="keywords" content="voyage, travel, actvite, destination, reservation ,nature">
    <meta name="author" content="Mina">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"><!--icon usee-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Voyage</title>
    <link rel="icon" href="img/logo.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link rel="icon" href="img/logo1.jpg" type="image/x-icon">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css"> <!-- icon reseau sociaux-->
    <link rel="stylesheet" href="styles/index.css" />
    <?php if ($title != "DASHBORD") {
        echo "<script src='js/main.js' defer></script>";
    }
    ?>
    <script src='js/main.js' defer></script>
    <script src='js/burger.js' defer></script>
    <link rel="stylesheet" href="css/style.css" />


</head>

<body id="pageLayout" class=" flex flex-col relative  bg-[#FAF5F1] no-repeat bg-cover    kanit-medium">
    <div class=" flex ">
        <aside class="hidden lg:block   bg-white bg-opacity-80   border-2 border-orange-100 rounded-xl w-1/5 p-2 pt-10">
            <div>
            <a href="#" class="font-bold font-sans hover:text-opacity-75 inline-flex items-center leading-none mr-4 space-x-1 text-orange-500 text-xl uppercase"><svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="2.5em" xml:space="preserve" fill="currentColor" viewBox="0 0 100 100" height="2.5em">
                        <path d="M38.333 80a11.571 11.571 0 0 1-7.646-2.883A11.724 11.724 0 0 1 26.834 70H10V46.667L43.333 40l20-20H90v26.667H43.995l-27.328 5.465v11.2h11.166a11.787 11.787 0 0 1 4.212-4.807 11.563 11.563 0 0 1 12.577 0 11.789 11.789 0 0 1 4.213 4.807h7.833V70h-6.837a11.719 11.719 0 0 1-3.853 7.117A11.571 11.571 0 0 1 38.333 80Zm0-16.667a5 5 0 1 0 5 5 5.006 5.006 0 0 0-5.001-5Zm27.761-36.666L52.762 40h30.571V26.667Z"></path>
                        <path d="M56.667 63.333h-7.833a11.6 11.6 0 0 0-21 0H16.667v-11.2l27.328-5.465h12.672Z" opacity="0.2"></path>
                        <path d="M90 63.333H80v-10h-6.667v10h-10V70h10v10H80V70h10Z"></path>
                        <path d="M52.762 40h30.571V26.667H66.094Z" opacity="0.2"></path>
                    </svg><span>Prime Drive</span> </a>
            </div>
            <nav id="menu" class="hidden lg:flex flex-col justify-center mx-auto items-center align-center mt-16">
            <?php
            if ($_SESSION['id_role'] == 1) {
                echo '
            <a href="home.php"
                class="text-orange-400 flex justify-center items-center m-2 w-2/3 border-2 cursor-pointer border-orange-400 rounded-lg hover:scale-[1.1] hover:text-gray-800">
                <span class="material-symbols-outlined cursor-pointer lg:text-4xl">Home</span> DashBorad
            </a>
                  <a href="categorie.php"
                class="text-orange-400 flex items-center justify-center m-2 w-2/3 border-2 cursor-pointer border-orange-400 rounded-lg hover:scale-[1.1] hover:text-gray-800">
                <span class="material-symbols-outlined cursor-pointer lg:text-4xl">kayaking</span> categorie
            </a>
            <a href="vehicule.php"
                class="text-orange-400 flex items-center justify-center m-2 w-2/3 border-2 cursor-pointer border-orange-400 rounded-lg hover:scale-[1.1] hover:text-gray-800">
                <span class="material-symbols-outlined cursor-pointer lg:text-4xl">kayaking</span> Véhicule
            </a>
            <a href="reservation.php"
                class="text-orange-400 flex items-center m-2 justify-center w-2/3 border-2 cursor-pointer border-orange-400 rounded-lg hover:scale-[1.1] hover:text-gray-800">
                <span class="material-symbols-outlined cursor-pointer lg:text-4xl">airplane_ticket</span> Réservation
            </a>';
            }
            if ($_SESSION['id_role'] == 2) {
                echo  '  <a href="home.php"
                class="text-orange-400 flex justify-center items-center m-2 w-2/3 border-2 cursor-pointer border-orange-400 rounded-lg hover:scale-[1.1] hover:text-gray-800">
                <span class="material-symbols-outlined cursor-pointer lg:text-4xl">Home</span> Home
            </a>
        ';
            }


            ?>
            </nav>
        </aside>
        <div class="w-full">
            <header class="p-5 lg:my-2.5 ">

                <div class=" mx-auto flex justify-between items-center">
                    <div>
                        <img class="lg:hidden mx-auto" src="img/logo.png" width="150" alt="logo">
                    </div>

                    <div class="flex  lg:ml-auto lg:flex-row flex-1  items-center  justify-end">

                        <div class='relative group z-50'>
                            <a href='#' id='menuToggle' class='flex flex-col items-center hover:text-[#FEA116] text-xl'>
                                <div><i class='fa-solid fa-user-tie'></i>
                                    <h5 class='text-sm text-orange-500'> <?= $_SESSION['id_user'] ?> <?= $_SESSION['nom'] ?> </h5>
                            </a>
                            <a href='../login/deconnecter.php' class='block hover:bg-gray-600 p-2 rounded text-sm'>deconnecter</a>

                        </div>


                    </div>
                    <div id="menuBurger" class="lg:hidden bg-black text-white p-4 absolute w-1/3 top-10 right-0 hidden">
                        <nav class="flex flex-col items-center">
                            <a href="index.php" class="hover:bg-white hover:text-black rounded px-3 py-1 mb-2">DashBoard</a>
                            <a href="reservation.php"
                                class="hover:bg-white hover:text-black rounded px-3 py-1 mb-2">Reservation</a>
                            <a href="vehicule.php" class="hover:bg-white hover:text-black rounded px-3 py-1 mb-2">Véhicule
                                Us</a>
                            <a href="categorie.php" class="hover:bg-white hover:text-black rounded px-3 py-1 mb-2">categorie</a>
                        </nav>
                    </div>
                    <div class="lg:hidden ml-auto order-3">
                        <button id="menu-button" class="text-black">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" class="w-8 h-8">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>




                </div>
                <!-- Menu burger-->

            </header>
            <div class="px-2.5">
                <hr class="border-t border-orange-400 opacity-50">

            </div>




            <div class=" flex justify-between lg:mx-20  mb-8      p-2 border-b-2 border-y-indigo-300  ">


                <h2 class="text-2xl text-indigo-800  "> <?php echo $title; ?></h2>


                <?php if ($title == "Gestion des reservations") {
                    echo $serachVehicule;
                } ?>

            </div>








            <main class="flex-grow ">

                <div class=" h-full flex flex-col lg:flex-row lg:px-[20px] gap-20 relative justify-cente">
                    <div class=" w-full ">
                        <?php
                        // Main contient les autres pages 
                        echo isset($content) ? $content : '<p>Bienvenue sur le site de réservation de voyages.</p>';
                        ?>
                    </div>

                </div>

        </div>
        </main>
    </div>
    </div>
    <footer class="mt-10">

        <section class=" flex flex-col md:flex-row items-center justify-between px-8 md:px-20git bra mb-5 ">
        <div>
            <a href="#" class="font-bold font-sans hover:text-opacity-75 inline-flex items-center leading-none mr-4 space-x-1 text-orange-500 text-xl uppercase"><svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="2.5em" xml:space="preserve" fill="currentColor" viewBox="0 0 100 100" height="2.5em">
                        <path d="M38.333 80a11.571 11.571 0 0 1-7.646-2.883A11.724 11.724 0 0 1 26.834 70H10V46.667L43.333 40l20-20H90v26.667H43.995l-27.328 5.465v11.2h11.166a11.787 11.787 0 0 1 4.212-4.807 11.563 11.563 0 0 1 12.577 0 11.789 11.789 0 0 1 4.213 4.807h7.833V70h-6.837a11.719 11.719 0 0 1-3.853 7.117A11.571 11.571 0 0 1 38.333 80Zm0-16.667a5 5 0 1 0 5 5 5.006 5.006 0 0 0-5.001-5Zm27.761-36.666L52.762 40h30.571V26.667Z"></path>
                        <path d="M56.667 63.333h-7.833a11.6 11.6 0 0 0-21 0H16.667v-11.2l27.328-5.465h12.672Z" opacity="0.2"></path>
                        <path d="M90 63.333H80v-10h-6.667v10h-10V70h10v10H80V70h10Z"></path>
                        <path d="M52.762 40h30.571V26.667H66.094Z" opacity="0.2"></path>
                    </svg><span>Prime Drive</span> </a>
            </div>
            <div class="text-orange-500">
                <h3 class="text-lg font-semibold">Follow us</h3>
                <div class="flex space-x-4">
                    <a href="#"><i class='bx bxl-facebook-circle'></i></a>
                    <a href="#"><i class='bx bxl-pinterest'></i></a>
                    <a href="#"><i class='bx bxl-whatsapp'></i></a>
                    <a href="#"><i class='bx bxl-instagram-alt'></i></a>
                </div>
            </div>
        </section>

        <hr class=" mx-10 border-t border-orange-400 opacity-80">

        <section class=" flex flex-col md:flex-row justify-between gap-10 sm:gap-20 px-14 py-10">
            <div class="flex flex-col justify-evenly sm:flex-row gap-10 md:gap-20 w-full text-orange-400">
                <div>
                    <h3 class="text-sm font-semibold mb-1">Catégorie</h3>
                    <hr class="my-2.5 border-t border-orange-400 opacity-80">
                    <div class="text-gray-800">
                        <a href="#">Sport</a>
                        <div><a href="#">Luxe</a></div>
                        <div><a href="#">Pick up</a></div>
                    </div>
                </div>
                <div>
                    <h3 class="text-sm font-bold mb-1">LIENS UTILES</h3>
                    <hr class="my-2.5 border-t border-orange-400 opacity-80">
                    <div class="text-gray-800">
                        <a href="#">FAQ</a>
                        <div><a href="#">Aide en ligne</a></div>
                        <div><a href="#">Conditions d'utilisation</a></div>
                    </div>
                </div>
                <div>
                    <h3 class="text-sm font-bold mb-1">SUPPORT</h3>
                    <hr class="my-2.5 border-t border-orange-400 opacity-80">
                    <div class="text-gray-800">
                        <a href="#">Contactez-nous</a>
                        <div><a href="#">Centre d'assistance</a></div>
                    </div>
                </div>

                <img src="img/footer.jpg" class="w-32 h-32">
            </div>


        </section>
        <div class="px-10">
            <hr class="border-t border-orange-400 opacity-50">
        </div>

        <div class="text-center pt-4 ">
            <p class="text-orange-300  p-4">© 2025-2030 Copyright VoYa
            </p>
        </div>

    </footer>

</body>

</html>