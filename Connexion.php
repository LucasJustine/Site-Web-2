<?php 
require("Header.php");
?>



    <div class="w3-content " style="max-width:600px" >
      <div class="w3-card-4 w3-light-gray" >
        <div class="w3-container <?=$color?>">
          <h2>Connexion</h2>
        </div>
        <form method="POST" action="Connexion/TestConnexion.php" class="w3-container w3-card-4  w3-text-black">
          <div class="w3-row w3-section ">
            <label>Login:</label>
            <input type="text"  name="login" class="w3-input w3-border ">
            <label >Mot de passe:</label>
            <input type="password" name="mdp" class="w3-input w3-border ">
            <?php
              if(isset($_GET['Connexion'])){
                $x = $_GET['Connexion'];
                if($x == "Rate") echo '<div class="w3-panel w3-red"> <p>Mot de passe incorrect.</p> </div>';
                else{
                  echo '<div class="w3-panel w3-red"> <p>Login inconnu</p> </div>';
                }
              }
              if(isset($_GET['Achat']))
              echo '<input type="hidden" name="achat" value="true" >';
            ?>

            <input class= "w3-2020-navy-blazer w3-margin w3-btn w3-round-xxlarge w3-hover-white w3-border w3-border-black"  type="submit" value="Envoyer">
            <a class="w3-margin <?=$color?> w3-btn w3-round-xxlarge w3-hover-white w3-border w3-border-black" href="Inscription.php"> Inscription </a> 
          </div>
        </form>
      </div>
    </div>
  </body>
</html>
