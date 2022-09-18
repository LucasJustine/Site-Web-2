<?php
$url = parse_url($_SERVER['REQUEST_URI']); // Recupère l'url sous forme d'array
$dernierMot = strrpos($url['path'],"/") +1 ; // Trouve le dernier mot séparer par un / +1 permet de ne pas prendre /
$longeur = strlen($url['path']);   // la longeur de la chaine, c'est seulement pour une taille max 
$sous = substr($url['path'],$dernierMot,$longeur); // Recupere donc le dernier mot 
$mot = explode(".",$sous); // Sépare le nom du ".php"
$mot=$mot[0];

session_start(); //Je vais améliorer en mettant des if. Comme ça tout ne sera pas tout le temps inclu
require("Connexion/ConnexionBD.php");
require("Informations/Information.php");
if($mot == "Produit" || $mot == "AchatVente") require("Informations/InfosProduit.php");
if($mot == "AchatVente") require("Informations/InfosAchatVente.php");
require("Color.php");
if($mot == "Profil")require("Informations/InfosHistorique.php");
if($mot == "Panier"){
    require("Informations/InfoPanier.php");
    require("FonctionPanier.php");
}
mysqli_close($db)?>

<!DOCTYPE html>
<html lang=fr>
<head>
<title> <?=$mot?></title>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-2020.css">
<link rel="stylesheet" href="CSS/doubleRange.css">
<link rel="stylesheet" href="CSS/Footer.css">
<?php 
if($mot == "Accueil") echo "<link rel=\"stylesheet\" href=\"CSS/accueil.css\">";
if($mot == "Produit") echo "<link rel=\"stylesheet\" href=\"CSS/Produit.css\">" ?>
</head>
 <body>
 <script>
    function w3_open() {
        document.getElementById("mySidebar").style.display = "block";
    }

    function w3_close() {
        document.getElementById("mySidebar").style.display = "none";
    }
</script>
    <!-- Barre de navigation -->
    <div class="w3-top <?=$color?> ">
        <!-- Barre de navigation sur grand écran -->
        <div class=" w3-bar w3-large w3-hide-small ">
            <a href="Accueil.php" class="w3-btn w3-padding-large w3-hover-white"><i class="fa fa-home"></i></a>
            <a href="Produit.php?page=1" class="w3-btn w3-padding-large w3-hover-white">Produit</a>
        <?php 
            if(isset($_SESSION['login'])){
                function image($resultatIMG,$taille){
                    if($resultatIMG['image'] != null)
                        echo '<img src = "Images/',$resultatIMG['image'],'" style = "width:',$taille,'px ;height:',$taille,'px" class="w3-circle" alt="" />';
                    else 
                        echo '<img src = "Images/profil.png" style = "width:',$taille,'px ;height:"',$taille,'px"" class="w3-circle" alt="" />';
                } ?>
                <div class = " w3-dropdown-hover  w3-right">
                        <div class="w3-btn  w3-hover-white ">
                        <?php image($resultatIMG,35); ?>
                        </div> 
                        <div class="w3-dropdown-content w3-bar-block w3-card-4" style="right:0" >
                            <a class="w3-btn w3-padding-large  w3-bar-item  " href="Profil.php">Profil</a>
                            <a class="w3-btn w3-padding-large w3-bar-item " href="Connexion/Deconnexion.php"> Se Déconnecter</a>
                        </div>
            </div>
        <?php }
    
        else{
                echo '<a href="Connexion.php" class="w3-btn w3-padding-large w3-hover-white w3-right">Se Connecter</a>';
        }?>
            <a href="Panier.php" class="w3-btn w3-padding-large w3-hover-white w3-right">Panier</a>
        </div>



        <div class=" <?=$color?> w3-hide-large w3-hide-medium w3-row ">
            <div class="w3-third w3-center">
                <button id="openNav" class="w3-button  w3-large w3-left " onclick="w3_open()">&#9776;</button> 
                <h3>Take my Tech</h3>
            </div> 
            
        </div>
    </div>
 
    <!-- Barre de navigation sur petit écran-->
    <div class="w3-sidebar w3-bar-block w3-border-right w3-center" style="display:none" id="mySidebar">
        <button class="w3-bar-item w3-button w3-large"
        onclick="w3_close()">Close &times;</button>
        <a href="Accueil.php" class="w3-bar-item w3-button"><i class="fa fa-home"></i></a>
        <a href="Produit.php?page=1" class="w3-bar-item w3-button">Produit</a>
        <a href="Panier.php" class="w3-bar-item w3-button">Panier</a>
        <?php 
            if(isset($_SESSION['login'])):?>
                <div class = " w3-dropdown-hover  w3-right">
                    <div class="w3-btn  w3-hover-white ">
                    <?php image($resultatIMG,30); ?>
                    </div> 
                    <div class="w3-dropdown-content w3-bar-block w3-card-4" style="right:0" >
                        <a class="w3-bar-item  w3-button " href="Profil.php">Profil</a>
                        <a class="w3-bar-item  w3-button " href="Connexion/Deconnexion.php"> Se Déconnecter</a>
                    </div>
                </div>
        <?php 
    
            else:?>
                <a href="Connexion.php" class="w3-bar-item  w3-button">Se Connecter</a>
            <?php endif;?>

    </div>
<br> <br> <br>
