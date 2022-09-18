<?php // Réaliser par Lucas JUSTINE?>
<?php

  session_start(); 
  include_once("ConnexionBD.php");
    $requete = "Select mdp,id from Customer natural join CustomerProtectedData where login =?";
    $stmt = mysqli_prepare($db,$requete);
    $login = $_POST['login'];
    

    $mdp = $_POST['mdp'];

    mysqli_stmt_bind_param($stmt,"s",$login);
    mysqli_stmt_execute($stmt);
    $res=mysqli_stmt_get_result($stmt);
    $resultat = mysqli_fetch_assoc($res);
    
    if($resultat == null){
        echo "Login inconnu";
        header('Location:../Connexion.php?Connexion=login');
        exit();
    }
    else{  
        if(!password_verify($mdp,$resultat['mdp'])){
            echo "Mauvais mdp";
            header('Location:../Connexion.php?Connexion=Rate');
            exit();
        }
        else {
          $_SESSION['login'] = $login;
          $_SESSION['id'] = $resultat['id'];
          if(isset($_POST['achat'])){
            header('Location:../Produit.php');
            exit();
          }
          else{
            header('Location:../Accueil.php');
            exit();
          }
        }
    }
?>