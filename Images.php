<?php // Réaliser par Lucas JUSTINE?>
<?php 
session_start();
require("Connexion/ConnexionBD.php");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    if(isset($_FILES["image"])){
        // Erreur de transfert
        if($_FILES["image"]["error"] > 0){
            header('Location:Profil.php?Erreur=1');
            exit();
        }
        $maxSize = 5 * 1024 *1024; 
        $nom = $_FILES["image"]["tmp_name"];
        $taille = $_FILES["image"]["size"];
        $type =  pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
        $extension = array("jpeg","jpg","png");
        // Taille trop grande 
        if($taille > $maxSize){
            header('Location:Profil.php?Erreur=2');
            exit();
        }
        // Mauvaise extension
        if(!in_array($type,$extension)){
            header('Location:Profil.php?Erreur=3');
            exit();
        }


        $requeteImage = "Select image from Customer where id = ?";
        $stmtImage = mysqli_prepare($db,$requeteImage);
        mysqli_stmt_bind_param($stmtImage,"s",$_SESSION['id']);
        mysqli_stmt_execute($stmtImage);
        $image = mysqli_stmt_get_result($stmtImage);
        $resultat = mysqli_fetch_assoc($image);

        if($resultat != null){
           unlink("Images/".$resultat['image']);
        }

        $fichierExt = "Images/".$_SESSION['id'].".".$type;
        $nomfichier =$_SESSION['id'].".".$type;

        
        echo $nomfichier;
        $insertionImage = "Update Customer set image = ? where id = ?";
        $prepareImage = mysqli_prepare($db,$insertionImage);
        mysqli_stmt_bind_param($prepareImage,"si",$nomfichier,$_SESSION['id']);
        mysqli_stmt_execute($prepareImage);

        move_uploaded_file($nom,$fichierExt);
        mysqli_close($db);
        header('Location:Profil.php');
        exit();
    }
  

