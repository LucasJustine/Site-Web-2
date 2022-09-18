<?php // Réaliser par Lucas JUSTINE?>

<?php 
session_start();
require("FonctionPanier.php");
if(isset($_POST['Modifier'])){
    $Modification = $_POST['Modification'];
    foreach ($Modification as $Modifier){
        $id = $Modifier[0];
        $quantite = $Modifier[1];
        $entreprise = $Modifier[2];
        $max =  $Modifier[3];
        modifierQTeArticle($id,$quantite,$entreprise,$max);
    }
    header('Location:Panier.php?Modification=true');
    exit();
}
    
elseif(isset($_GET['id'])){
    $Supprimer = $_GET['id'];

    $array = explode(',',$Supprimer);
    $id = $array[0];
    $entreprise = $array[1];

    SupprimerArticle($id,$entreprise);
    // Id - Entreprise
    header('Location:Panier.php');
    exit();
}