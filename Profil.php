
<?php // Réaliser par Lucas JUSTINE?>
<?php
require("Header.php");


if(isset($_GET['Modification'])){
       $erreur = $_GET['Modification'];
    }
if(!isset($_SESSION['id'])){
  header('Location:Connexion.php');
  exit();
}
  
?>

    <!-- Conteneur global -->
    <div class="w3-row w3-container w3-padding-16  ">
        
    <!-- Conteneur Profil gauche -->
      <div class="w3-col m2 " >
        <div class=" w3-border w3-card " >
          <div>
              <img src="Images/<?=$resultatIMG['image']?>" alt="" class="w3-image" >
            <div class="w3-container">
              <p> Login : <span  class="w3-right w3-tag"> <?= $resultat['login'] ?> </span> </p>
              <p> Prenom : <span  class="w3-right w3-tag"> <?=$resultat['firstname']?>  </span> </p>
              <p> Nom : <span  class="w3-right w3-tag"> <?=$resultat['surname'] ?></span> </p>
              <p> Email : <span  class="w3-right w3-tag"> <?= $resultat['email'] ?> </span> </p>
              <p > Editer le profil   <i class="fa fa-pencil w3-right w3-btn" style="font-size:24px" onclick="document.getElementById('profil').style.display='block'"></i></p>
              </div>
          </div>
        
        <!-- Modal -->
        <div id="profil" class="w3-modal">
          <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
            <div class = "w3-container w3-center">
            <span onclick="document.getElementById('profil').style.display='none'" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
              <h3>Nouvelle image de profil ?</h3>
            </div>
            <div class="w3-center w3-large">
            
              <div class = "w3-padding">
                <?php 
                    image($resultatIMG,70,"w3-circle");
                ?>  
              </div>
                <div class = "w3-container">
                  <form action="Images.php" method="post" enctype="multipart/form-data">
                    Images:
                    <input type="file" name="image" id="image"><br><br>
                    <input type="submit" value="Envoyer Image" name="submit">

                    <?php if(isset($_GET['Erreur'])){
                      switch($_GET['Erreur']){
                        case 1:
                          echo '<div class="w3-panel w3-red"> <p>Impossible d\'envoyer l\'image </p> </div>';
                          break;

                        case 2:
                          echo '<div class="w3-panel w3-green"> <p>Image envoyé</p> </div>';
                          break;
                      }
                    }?>
                </form>
              </div>
            </div>
            <hr>
            <form class="w3-container" method="post" action = "Connexion/Modifier.php" >

                <p> <label>Login:</label>
                <input class ="w3-input w3-border w3-grey w3-round-large" type="text"  name="login"  value ="<?php echo $resultat['login'] ?>" readonly ></p>
              

                <p> <label>Nom:</label>
                <input class ="w3-input w3-border w3-grey w3-round-large" type="text" name="nom" value = "<?php echo $resultat['surname'] ?>" readonly> </p>

                <p> <label>Prenom:</label>
                <input class ="w3-input w3-border w3-grey w3-round-large" type="text" name="prenom" value = "<?php echo $resultat['firstname']?>" readonly >  </p>

                <p> <label >Email:</label>
                <input class ="w3-input w3-border w3-grey w3-round-large" type="email"  name="email" value = "<?php echo $resultat['email']?> " readonly></p>

                <p> <label >Mdp:</label>
                <input class ="w3-input w3-border w3-sand w3-round-large" type="password" name="mdp"  ></p>

                <p><input  class= "w3-brown w3-margin w3-btn w3-round-large" type="submit" value="Enregistrer"></p>
              </form>
            </div>
          </div>
        </div>
            
        <div class="w3-bar-block w3-center w3-border w3-card-4 <?=$color?> w3-margin-top ">
          <div class="w3-button w3-bar-item w3-mobile  " onclick="openPanel('recyclage')">Recyclage</div>
          <div class="w3-button w3-bar-item w3-mobile" onclick="openPanel('cagnotte')">Cagnotte</div>
          <div class="w3-button w3-bar-item w3-mobile" onclick="openPanel('historiqueAchat')">Historique d'achat</div>
          <div class="w3-button w3-bar-item w3-mobile" onclick="openPanel('historiqueVente')">Historique de vente</div>
        </div>
          <?php if(isset($_GET['Modification'])){
                  switch($erreur){
                      case "surname":
                        echo '<div class="w3-panel w3-red"> <p>Prenom non conforme</p> </div>';
                        break;

                      case "firstname":
                        echo '<div class="w3-panel w3-red"> <p>Nom non conforme</p> </div>';
                        break;

                      case "reussi":
                        echo '<div class="w3-panel w3-green"> <p>Enregistrement effectué</p> </div>';
                        break;
                }
              }?>
      </div>
    


    <!-- Conteneur Profil droit -->
      <div class="w3-rest w3-container ">

        <div id = "recyclage" class = "  w3-container w3-center change">
          <p> Constater l'étendue de votre recyclage </p>
              <?php require("Informations/Elements.php");?>
        </div>
        <div  id = "cagnotte"  class=" w3-row-padding w3-padding-64 w3-container w3-content  change" style="display:none">      
          <div class="w3-padding-64" > 
            <p>  Votre cagnotte </p>
            <div class="w3-grey w3-round ">
              <div class="w3-container w3-round <?=$color?> w3-text-black w3-padding-16  w3-center" style="width:
              <?php echo  ($resultat['stash']/640) ?>%"><?php echo ($resultat['stash']) ?> Euros</div>
            </div> 
          </div>
        </div>
    

        <div id = "historiqueAchat" class = "w3-container w3-center w3-padding-64 change" style="display:none">
          <?php require("Informations/Historique.php");?>
        </div>

        <div id = "historiqueVente" class = "w3-container w3-center w3-padding-64 change" style="display:none">
          <?php require("Informations/HistoriqueVente.php");?>
        </div>
        </div>
        
    </div>


      <script>
    function openPanel(panel) {
      var i;
      var x = document.getElementsByClassName("change");
      for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";  
      }
      document.getElementById(panel).style.display = "block";  
    }


    function Reveal(id) {
      var x = document.getElementById(id);
      if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
      } else { 
        x.className = x.className.replace(" w3-show", "");
      }
    }

    </script>
</body>
</html>