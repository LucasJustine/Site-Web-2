<?php // Réaliser par Lucas JUSTINE?>
<?php
  include_once("ConnexionBD.php");
      //Requetes pour la base de donnée
      $requete1 = "Insert into Customer(login,stash,image) values(?,0,\"\")";
      $requete2 = "Insert into CustomerProtectedData values(?,?,?,?,?)";
      $requetelogin = "Select * from Customer where login = ?";
      $requetemail = "Select * from CustomerProtectedData where email = ?";

      
      //Récupération du login pour la requete
      $login = $_POST['login'];
      //Vérififcation de la variable
      if(!preg_match('/^[A-Za-z0-9]+$/',$login)){
        mysqli_close($db);
        header('Location:../Inscription.php?Inscription=login');
        exit();
      }

      //Variable pour la requete
      $nom = $_POST['nom'];
      if(!preg_match('/^[A-Za-z]+$/',$nom)){
        header('Location:../Inscription.php?Inscription=Nom');
        exit();
      }
      $prenom = $_POST['prenom'];
      if(!preg_match('/^[A-Za-z]+$/',$prenom)){
        header('Location:../Inscription.php?Inscription=Prenom');
        exit();
      }
      $mail = filter_var($_POST['mail'], FILTER_SANITIZE_EMAIL);
      if(!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        header('Location:../Inscription.php?Inscription=mail');
        exit();
      }

      
      // Préparation d'une requete ( Login )
      $requeteLogin = mysqli_prepare($db,$requetelogin);
      mysqli_stmt_bind_param($requeteLogin,"s",$login);
      //Execution de la requete 
      mysqli_stmt_execute($requeteLogin);
      $resultat=mysqli_stmt_get_result($requeteLogin);
      $resultatlogin = mysqli_fetch_assoc($resultat);
      if($resultatlogin != null){
        header('Location:../Inscription.php?Inscription=Login');
        exit();
      }

      // Préparation d'une requete ( Email )
      $requeteEmail = mysqli_prepare($db,$requetemail);
      mysqli_stmt_bind_param($requeteEmail,"s",$mail);
      //Execution de la requete 
      mysqli_stmt_execute($requeteEmail);
      $resultatemail=mysqli_stmt_get_result($requeteEmail);
      $resultatmail = mysqli_fetch_assoc($resultatemail);
      if($resultatmail != null){
        header('Location:../Inscription.php?Inscription=mailexiste');
        exit();
      }
      
      // Préparation d'une requete ( Customer )
      $stmt = mysqli_prepare($db,$requete1);
      //Remplacement du ? par le login 
      mysqli_stmt_bind_param($stmt,"s",$login);
      //Execution de la requete 
      $res1= mysqli_stmt_execute($stmt);

      //Requete pour l'id du login associé
      $reslogin=mysqli_query($db,"select id from Customer where login = \"$login\" ");
      //Récuperation de l'id pour la 2ieme requete
      $resid = mysqli_fetch_assoc($reslogin);
      $id = $resid['id'];

     


      // Préparation d'une requete  ( CustomerProtectedData )
      $stmt2 = mysqli_prepare($db,$requete2);
      
      $mdp = $_POST['mdp'];
      //Hashage du mdp
      $mot = password_hash($mdp,PASSWORD_DEFAULT);
      //Remplacement des ? par les variables 
      mysqli_stmt_bind_param($stmt2,"sssss",$id,$nom,$prenom,$mail,$mot);
      //Execution de la requete 
      $res2= mysqli_stmt_execute($stmt2);

     header('Location:../Connexion.php');
     exit();
   
?>