<?php // Réaliser par Lucas JUSTINE?>
<?php
session_start();

include_once("ConnexionBD.php");
    //requete pour Modifier le mot de passe 
    $requete = "Update CustomerProtectedData set mdp = ? where id = ? ";

    $mdp = $_POST['mdp'];
    //Si le mdp est pas null, alors il change
    if($mdp != null){
        $stmt = mysqli_prepare($db,$requete);
        $mot = password_hash($mdp,PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt,"si",$mot,$_SESSION['id']);
        mysqli_stmt_execute($stmt);
        header('Location:../Profil.php?Modification=reussi');
        exit();
    }
    
    header('Location:../Profil.php');
    exit();
?>