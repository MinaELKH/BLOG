
<?php




spl_autoload_register(function ($class) {
    $file = __DIR__ . '/Includ/' . str_replace('\\', '/', $class) . '.php';
    // Vérifie si le fichier existe et l'inclut
    if (file_exists($file)) {
        require_once $file;
    }
    //  else {
    //     echo "Fichier non trouvé : $file\n";
    // }
});


spl_autoload_register(function ($class) {
    // Convertit le namespace en chemin de fichier
    $file = __DIR__ . '/app/BLOG/' . str_replace('\\', '/', $class) . '.php';
    // Vérifie si le fichier existe et l'inclut
    if (file_exists($file)) {
        require_once $file;
    } 
    // else {
    //     echo "Fichier non trouvé : $file\n";
    // }
});






// new App\Controllers\HomeController();  // Appelle l'autoloader 1
// new External\Library\SomeClass();    