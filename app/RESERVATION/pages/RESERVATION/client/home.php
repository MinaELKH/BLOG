<?php
ob_start();
session_start();

use  ModelsReservation\Vehicule ; 
use  ModelsReservation\Categorie ; 
use  ModelsReservation\Reservation ; 
use  ModelsReservation\Client ; 
use Models\DatabaseManager ;


require("../../sweetAlert/sweetAlert.php");
// require_once __DIR__ . "/../backend/classe_Vehicule.php";
// require_once __DIR__ . "/../backend/classe_Categorie.php";
// require_once __DIR__ . "/../backend/classe_Reservation.php";
// require_once __DIR__ . "/../backend/classe_client.php";
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script><!--sweet alert-->

    <script src="js/main.js" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"><!--icon usee-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <script src="js/liste_vehicule.js" defer></script> <!-- js qui contient le fetch de la liste de vehiclue-->
    <link href="template/PrimeDrive_TW/tailwind_theme/tailwind.css" rel="stylesheet" type="text/css">
    <script>
        /* Pinegrow Interactions, do not remove */
        (function() {
            try {
                if (!document.documentElement.hasAttribute('data-pg-ia-disabled')) {
                    window.pgia_small_mq = typeof pgia_small_mq == 'string' ? pgia_small_mq : '(max-width:767px)';
                    window.pgia_large_mq = typeof pgia_large_mq == 'string' ? pgia_large_mq : '(min-width:768px)';
                    var style = document.createElement('style');
                    var pgcss = 'html:not(.pg-ia-no-preview) [data-pg-ia-hide=""] {opacity:0;visibility:hidden;}html:not(.pg-ia-no-preview) [data-pg-ia-show=""] {opacity:1;visibility:visible;display:block;}';
                    if (document.documentElement.hasAttribute('data-pg-id') && document.documentElement.hasAttribute('data-pg-mobile')) {
                        pgia_small_mq = '(min-width:0)';
                        pgia_large_mq = '(min-width:99999px)'
                    }
                    pgcss += '@media ' + pgia_small_mq + '{ html:not(.pg-ia-no-preview) [data-pg-ia-hide="mobile"] {opacity:0;visibility:hidden;}html:not(.pg-ia-no-preview) [data-pg-ia-show="mobile"] {opacity:1;visibility:visible;display:block;}}';
                    pgcss += '@media ' + pgia_large_mq + '{html:not(.pg-ia-no-preview) [data-pg-ia-hide="desktop"] {opacity:0;visibility:hidden;}html:not(.pg-ia-no-preview) [data-pg-ia-show="desktop"] {opacity:1;visibility:visible;display:block;}}';
                    style.innerHTML = pgcss;
                    document.querySelector('head').appendChild(style);
                }
            } catch (e) {
                console && console.log(e);
            }
        })()
    </script>
</head>

<body id="pageHome" class="font-serif text-gray-500">
    <header class="bg-gray-900 bg-opacity-95 py-2">
        <div class="container mx-auto relative">
            <nav class="flex flex-wrap items-center px-4">
                <a href="#" class="font-bold font-sans hover:text-opacity-75 inline-flex items-center leading-none mr-4 space-x-1 text-primary-500 text-xl uppercase"><svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="2.5em" xml:space="preserve" fill="currentColor" viewBox="0 0 100 100" height="2.5em">
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
                        <a href="#" class="hover:text-gray-400 lg:p-4 py-2 text-white">Acceuil</a>
                        <a href="#" class="hover:text-gray-400 lg:p-4 py-2 text-white">Offre</a>
                        <a href="#" class="hover:text-gray-400 lg:p-4 py-2 text-white">Locations</a>
                        <a href="#" class="hover:text-gray-400 lg:p-4 py-2 text-white">Support</a>
                    </div>
                    <?php
                    if (isset($_SESSION['id_role']) &&  $_SESSION['id_role'] == 2) {
                        echo " <div class='relative group z-50'>
                                    <a href='#' id='menuToggle' class='flex flex-col items-center hover:text-[#FEA116] text-xl'>
                                    <div><i class='fa-solid fa-user-tie'></i>
                                    <i class='fa fa-caret-down'></i></div>
                                        <h5 class='text-sm text-primary-500'>" . $_SESSION['id_user'] . " " . $_SESSION['nom'] . "</h5>
                                    </a>
                                    <div
                                    id='dropdownMenu'
                                    class='absolute hidden bg-gray-800 text-white mt-2 rounded shadow-md p-2 space-y-2 '
                                    >
                                    <a href='espaceClient.php' class='block hover:bg-gray-700 p-2 rounded  text-sm'>Mon espace</a>
                                    <a href='../login/deconnecter.php' class='block hover:bg-gray-700 p-2 rounded text-sm'>quiter</a>
                                   
                                    </div>
                                </div>
                                            ";
                    } else {
                        echo  '<div class="flex-wrap inline-flex items-center py-1 space-x-2"> 
                                <a href="../login/login.php" class="border border-primary-500 hover:bg-primary-500 hover:text-white inline-block px-6 py-2 text-primary-500">
                                Log In</a>
                                <a href="../login/register.php" class="bg-primary-500 border border-primary-500 hover:bg-primary-600 inline-block px-6 py-2 text-white">
                                Sign Up</a> 
                            </div>
                         ';
                    }
                    ?>
                </div>
            </nav>
        </div>
    </header>
    <main>
        <section class="bg-secondary-500 poster relative text-gray-300">
            <div class="container mx-auto pb-24 pt-72 px-4">
                <div class="-mx-4 flex flex-wrap items-center space-y-6 lg:space-y-0">
                    <div class="px-4 w-full md:w-9/12 xl:w-7/12 2xl:w-6/12">
                        <p class="font-bold font-sans mb-1 text-2xl text-white">Location de voitures</p>
                        <h1 class="font-bold mb-6 text-5xl text-white md:leading-tight lg:leading-tight lg:text-6xl">For Your <span class="text-primary-500">Trajet quotidien</span> or <span class="text-primary-500">Leisure</span></h1>
                        <div class="flex justify-between bg-white p-6">
                            <h2 class="font-bold mb-2 text-gray-900 text-xl">Trouvons votre voiture idéale</h2>
                            <a href="homeFilterVehicule.php" class="self-end bg-primary-500 hover:bg-primary-600 inline-block px-6 py-2 text-center text-white"><span>Faire Votre filtre </span></a> 
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-24">
            <div class="container mx-auto px-4">
                <div class="-mx-4 flex flex-wrap items-center mb-6">
                    <div class="px-4 w-full md:w-10/12">
                        <h2 class="font-medium mb-1 text-primary-500 text-xl">Nos Meilleures Voitures</h2>
                        <h3 class="capitalize font-bold mb-4 text-4xl text-gray-900">Des voitures pour tous vos besoins</h3>
                        <div class="bg-primary-500 mb-6 pb-1 w-2/12"></div>
                    </div>
                </div>
            </div>

            <div id="vehiculesContainer" class="grid grid-cols-4 gap-4 container mx-auto px-4">
                <!-- Les véhicules filtrés s'afficheront ici -->
            </div>
        </section>
   

        <section class="py-24">
            <div class="container mx-auto px-4">
                <div class="-mx-4 flex flex-wrap items-center mb-6">
                    <div class="px-4 w-full md:flex-1">
                        <h2 class="font-medium mb-1 text-primary-500 text-xl">Our Fleet</h2>
                        <h3 class="capitalize font-bold mb-4 text-4xl text-gray-900">Browse by Category</h3>
                        <div class="bg-primary-500 mb-6 pb-1 w-2/12"></div>
                    </div>
                    <div class="px-4 w-full md:w-auto">
                        <a href="#" class="bg-primary-500 hover:bg-primary-600 inline-block px-6 py-2 text-white">View All</a>
                    </div>
                </div>
                <div class="-mx-3 flex flex-wrap justify-center">
                    <div class="p-3 w-full md:w-6/12 lg:w-3/12">
                        <a href="#" class="bg-white block border group hover:text-gray-500 shadow-md text-gray-900"><img src="https://images.unsplash.com/photo-1619767886558-efdc259cde1a?ixid=MnwyMDkyMnwwfDF8c2VhcmNofDMyM3x8c3V2fGVufDB8fHx8MTYzMTY4Njc4Nw&ixlib=rb-1.2.1q=85&fm=jpg&crop=faces&cs=srgb&w=600&h=450&fit=crop" class="group-hover:opacity-90 w-full" alt="..." width="600" height="450" />
                            <div class="px-6 py-4">
                                <h4 class="font-bold text-xl">Sedans</h4>
                            </div>
                        </a>
                    </div>
                    <div class="p-3 w-full md:w-6/12 lg:w-3/12">
                        <a href="#" class="bg-white block border group hover:text-gray-500 shadow-md text-gray-900"><img src="https://images.unsplash.com/photo-1511527844068-006b95d162c2?ixid=MnwyMDkyMnwwfDF8c2VhcmNofDQzfHxjYXIlMjBzdXZ8ZW58MHx8fHwxNjMxNjg0ODkw&ixlib=rb-1.2.1q=85&fm=jpg&crop=faces&cs=srgb&w=600&h=450&fit=crop" class="group-hover:opacity-90 w-full" alt="..." width="600" height="450" />
                            <div class="px-6 py-4">
                                <h4 class="font-bold text-xl">SUVs</h4>
                            </div>
                        </a>
                    </div>
                    <div class="p-3 w-full md:w-6/12 lg:w-3/12">
                        <a href="#" class="bg-white block border group hover:text-gray-500 shadow-md text-gray-900"><img src="https://images.unsplash.com/photo-1597210159614-966c9f632c89?ixid=MnwyMDkyMnwwfDF8c2VhcmNofDh8fGNhciUyMGNvbnZlcnRpYmxlfGVufDB8fHx8MTYzMTY4NTExMA&ixlib=rb-1.2.1q=85&fm=jpg&crop=faces&cs=srgb&w=600&h=450&fit=crop" class="group-hover:opacity-90 w-full" alt="..." width="600" height="450" />
                            <div class="px-6 py-4">
                                <h4 class="font-bold text-xl">Convertibles</h4>
                            </div>
                        </a>
                    </div>
                    <div class="p-3 w-full md:w-6/12 lg:w-3/12">
                        <a href="#" class="bg-white block border group hover:text-gray-500 shadow-md text-gray-900"><img src="https://images.unsplash.com/photo-1552519507-da3b142c6e3d?ixid=MnwyMDkyMnwwfDF8c2VhcmNofDMwfHxzcG9ydHMlMjBjYXJ8ZW58MHx8fHwxNjMxNjg3MzQ4&ixlib=rb-1.2.1q=85&fm=jpg&crop=faces&cs=srgb&w=600&h=450&fit=crop" class="group-hover:opacity-90 w-full" alt="..." width="600" height="450" />
                            <div class="px-6 py-4">
                                <h4 class="font-bold text-xl">Sports Cars</h4>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <?php require_once('formReservation.php'); ?>
    </main>
    <footer class="bg-black bg-opacity-90 pt-12 text-gray-300">
        <div class="container mx-auto px-4 relative">
            <div class="flex flex-wrap -mx-4">
                <div class="p-4 w-full lg:w-4/12">
                    <a href="#" class="font-bold font-sans hover:text-opacity-90 inline-flex items-center leading-none mb-4 space-x-2 text-3xl text-primary-500 uppercase"> <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="3em" xml:space="preserve" fill="currentColor" viewBox="0 0 100 100" height="3em">
                            <path d="M38.333 80a11.571 11.571 0 0 1-7.646-2.883A11.724 11.724 0 0 1 26.834 70H10V46.667L43.333 40l20-20H90v26.667H43.995l-27.328 5.465v11.2h11.166a11.787 11.787 0 0 1 4.212-4.807 11.563 11.563 0 0 1 12.577 0 11.789 11.789 0 0 1 4.213 4.807h7.833V70h-6.837a11.719 11.719 0 0 1-3.853 7.117A11.571 11.571 0 0 1 38.333 80Zm0-16.667a5 5 0 1 0 5 5 5.006 5.006 0 0 0-5.001-5Zm27.761-36.666L52.762 40h30.571V26.667Z"></path>
                            <path d="M56.667 63.333h-7.833a11.6 11.6 0 0 0-21 0H16.667v-11.2l27.328-5.465h12.672Z" opacity="0.2"></path>
                            <path d="M90 63.333H80v-10h-6.667v10h-10V70h10v10H80V70h10Z"></path>
                            <path d="M52.762 40h30.571V26.667H66.094Z" opacity="0.2"></path>
                        </svg><span>Prime Drive</span> </a>
                    <ul class="mb-4 space-y-1">
                        <li>9056 Fairground Ave., New York, USA</li>
                        <li>
                            <a href="#" class="hover:text-gray-400 text-white">+0 123 456 7890</a>
                        </li>
                        <li>
                            <a href="mailto:hello@fafo.com" class="hover:text-gray-400 text-white">info@company.com</a>
                        </li>
                    </ul>
                    <div class="flex-wrap inline-flex space-x-3">
                        <a href="#" aria-label="facebook" class="hover:text-gray-400"> <svg viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                                <path d="M14 13.5h2.5l1-4H14v-2c0-1.03 0-2 2-2h1.5V2.14c-.326-.043-1.557-.14-2.857-.14C11.928 2 10 3.657 10 6.7v2.8H7v4h3V22h4v-8.5z" />
                            </svg></a>
                        <a href="#" aria-label="twitter" class="hover:text-gray-400"> <svg viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                                <path d="M22.162 5.656a8.384 8.384 0 0 1-2.402.658A4.196 4.196 0 0 0 21.6 4c-.82.488-1.719.83-2.656 1.015a4.182 4.182 0 0 0-7.126 3.814 11.874 11.874 0 0 1-8.62-4.37 4.168 4.168 0 0 0-.566 2.103c0 1.45.738 2.731 1.86 3.481a4.168 4.168 0 0 1-1.894-.523v.052a4.185 4.185 0 0 0 3.355 4.101 4.21 4.21 0 0 1-1.89.072A4.185 4.185 0 0 0 7.97 16.65a8.394 8.394 0 0 1-6.191 1.732 11.83 11.83 0 0 0 6.41 1.88c7.693 0 11.9-6.373 11.9-11.9 0-.18-.005-.362-.013-.54a8.496 8.496 0 0 0 2.087-2.165z" />
                            </svg></a>
                        <a href="#" aria-label="instagram" class="hover:text-gray-400"> <svg viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                                <path d="M12 2c2.717 0 3.056.01 4.122.06 1.065.05 1.79.217 2.428.465.66.254 1.216.598 1.772 1.153a4.908 4.908 0 0 1 1.153 1.772c.247.637.415 1.363.465 2.428.047 1.066.06 1.405.06 4.122 0 2.717-.01 3.056-.06 4.122-.05 1.065-.218 1.79-.465 2.428a4.883 4.883 0 0 1-1.153 1.772 4.915 4.915 0 0 1-1.772 1.153c-.637.247-1.363.415-2.428.465-1.066.047-1.405.06-4.122.06-2.717 0-3.056-.01-4.122-.06-1.065-.05-1.79-.218-2.428-.465a4.89 4.89 0 0 1-1.772-1.153 4.904 4.904 0 0 1-1.153-1.772c-.248-.637-.415-1.363-.465-2.428C2.013 15.056 2 14.717 2 12c0-2.717.01-3.056.06-4.122.05-1.066.217-1.79.465-2.428a4.88 4.88 0 0 1 1.153-1.772A4.897 4.897 0 0 1 5.45 2.525c.638-.248 1.362-.415 2.428-.465C8.944 2.013 9.283 2 12 2zm0 5a5 5 0 1 0 0 10 5 5 0 0 0 0-10zm6.5-.25a1.25 1.25 0 0 0-2.5 0 1.25 1.25 0 0 0 2.5 0zM12 9a3 3 0 1 1 0 6 3 3 0 0 1 0-6z" />
                            </svg></a>
                        <a href="#" aria-label="linkedin" class="hover:text-gray-400"> <svg viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                                <path d="M6.94 5a2 2 0 1 1-4-.002 2 2 0 0 1 4 .002zM7 8.48H3V21h4V8.48zm6.32 0H9.34V21h3.94v-6.57c0-3.66 4.77-4 4.77 0V21H22v-7.93c0-6.17-7.06-5.94-8.72-2.91l.04-1.68z" />
                            </svg></a>
                        <a href="#" aria-label="youtube" class="hover:text-gray-400"> <svg viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                                <path d="M21.543 6.498C22 8.28 22 12 22 12s0 3.72-.457 5.502c-.254.985-.997 1.76-1.938 2.022C17.896 20 12 20 12 20s-5.893 0-7.605-.476c-.945-.266-1.687-1.04-1.938-2.022C2 15.72 2 12 2 12s0-3.72.457-5.502c.254-.985.997-1.76 1.938-2.022C6.107 4 12 4 12 4s5.896 0 7.605.476c.945.266 1.687 1.04 1.938 2.022zM10 15.5l6-3.5-6-3.5v7z" />
                            </svg></a>
                    </div>
                </div>
                <div class="p-4 w-full sm:w-6/12 md:flex-1 lg:w-3/12">
                    <h2 class="font-bold text-color3-500 text-xl">Company</h2>
                    <hr class="border-gray-600 inline-block mb-6 mt-4 w-3/12">
                    <ul>
                        <li class="mb-4">
                            <a href="#" class="hover:text-gray-400">FAQ</a>
                        </li>
                        <li class="mb-4">
                            <a href="#" class="hover:text-gray-400">News</a>
                        </li>
                        <li class="mb-4">
                            <a href="#" class="hover:text-gray-400">Careers</a>
                        </li>
                        <li class="mb-4">
                            <a href="#" class="hover:text-gray-400">About Us</a>
                        </li>
                        <li class="mb-4">
                            <a href="#" class="hover:text-gray-400">Contact Us</a>
                        </li>
                    </ul>
                </div>
                <div class="p-4 w-full sm:w-6/12 md:flex-1 lg:w-3/12">
                    <h2 class="font-bold text-color3-500 text-xl">Vehicles</h2>
                    <hr class="border-gray-600 inline-block mb-6 mt-4 w-3/12">
                    <ul>
                        <li class="mb-4">
                            <a href="#" class="hover:text-gray-400">SUVs</a>
                        </li>
                        <li class="mb-4">
                            <a href="#" class="hover:text-gray-400">Sedans</a>
                        </li>
                        <li class="mb-4">
                            <a href="#" class="hover:text-gray-400">Mini Vans</a>
                        </li>
                        <li class="mb-4">
                            <a href="#" class="hover:text-gray-400">Sports Cars</a>
                        </li>
                        <li class="mb-4">
                            <a href="#" class="hover:text-gray-400">Convertibles</a>
                        </li>
                    </ul>
                </div>
                <div class="p-4 w-full md:w-5/12 lg:w-4/12">
                    <h2 class="font-bold text-color3-500 text-xl">Top Cities</h2>
                    <hr class="border-gray-600 inline-block mb-6 mt-4 w-3/12">
                    <div class="-mx-4 flex flex-wrap">
                        <div class="pb-4 px-4 w-full sm:w-6/12">
                            <ul>
                                <li class="mb-4">
                                    <a href="#" class="hover:text-gray-400">Taxes</a>
                                </li>
                                <li class="mb-4">
                                    <a href="#" class="hover:text-gray-400">Boston</a>
                                </li>
                                <li class="mb-4">
                                    <a href="#" class="hover:text-gray-400">Colorado</a>
                                </li>
                                <li class="mb-4">
                                    <a href="#" class="hover:text-gray-400">California</a>
                                </li>
                                <li class="mb-4">
                                    <a href="#" class="hover:text-gray-400">Manhattan</a>
                                </li>
                            </ul>
                        </div>
                        <div class="pb-4 px-4 w-full sm:w-6/12">
                            <ul>
                                <li class="mb-4">
                                    <a href="#" class="hover:text-gray-400">Dallas</a>
                                </li>
                                <li class="mb-4">
                                    <a href="#" class="hover:text-gray-400">Huston</a>
                                </li>
                                <li class="mb-4">
                                    <a href="#" class="hover:text-gray-400">Seattle</a>
                                </li>
                                <li class="mb-4">
                                    <a href="#" class="hover:text-gray-400">Denver</a>
                                </li>
                                <li class="mb-4">
                                    <a href="#" class="hover:text-gray-400">Phoenix</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="py-4">
                <hr class="mb-4 opacity-25">
                <div class="flex flex-wrap -mx-4  items-center">
                    <div class="px-4 py-2 w-full md:flex-1">
                        <p>&copy; 2002 - 2021. All Rights Reserved - Company Name</p>
                    </div>
                    <div class="px-4 py-2 w-full md:w-auto">
                        <a href="#" class="hover:text-gray-400">Privacy Policy</a> |
                        <a href="#" class="hover:text-gray-400">Terms of Use</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    

</body>



<!-- formulaire de reservation -->







</html>