<?php // Réaliser par Lucas JUSTINE?>
<?php
  
    // On démarre la session
    session_start();
  
    if(isset($_SESSION['login'])) { // Si tu es connecté on te déconnecte et on te redirige vers une page.
  
        // Supression de la session;
        $_SESSION = array(); 
        session_destroy();
          
        header('Location:../Accueil.php');
        exit();
    }else{ // Dans le cas contraire on t'empêche d'accéder à cette page en te redirigeant vers la page que tu veux.
  
        header('Location:../Accueil.php');
        exit();
    }   
 
?>