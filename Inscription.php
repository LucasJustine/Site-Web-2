<?php // Réaliser par Lucas JUSTINE?>
<?php require("Header.php"); ?>

        <div class=" w3-content " style="width:600px">
            <div class="w3-card-4 w3-light-gray" >
                <div class="w3-container  <?=$color?> ">
                    <h2>Inscription</h2>
                </div>
                    <?php if(isset($_GET['Inscription'])){
                    $erreur = $_GET['Inscription'];
                    }
                    ?>
            
                <form method = "post" action="Connexion/TestInscription.php" class="w3-container w3-card-4  w3-text-black">
                    <div class="w3-row w3-section">

                    <label >Login:</label>
                    <input class ="w3-input w3-border  " type="text"  name="login" required >
                    <?php
                    if(isset($_GET['Inscription'])){
                        if($erreur == 'Login'){
                            echo '<div class="w3-panel w3-red"> <p>Login déjà utilisé</p> </div>';
                        }
                        if($erreur == 'login'){
                            echo '<div class="w3-panel w3-red"> <p>Nombre dans le login</p> </div>';
                        }
                    }
                
                    ?>

                    <label >Nom:</label>
                    <input class ="w3-input w3-border " type="text" name="nom" required >
                    <?php
                    if(isset($_GET['Inscription'])){
                        if($erreur == 'Nom'){
                            echo '<div class="w3-panel w3-red"> <p>Nom non conforme</p> </div>';
                        }
                    }
                    ?>
                    <label >Prénom:</label>
                    <input class ="w3-input w3-border " type="text" name="prenom"  required> 
                    <?php
                    if(isset($_GET['Inscription'])){
                        if($erreur == 'Prenom'){
                            echo '<div class="w3-panel w3-red"> <p>Prenom non conforme</p> </div>';
                        }
                    }
                    ?>
                    <label >Email:</label>
                    <input class ="w3-input w3-border" type="text"  name="mail" required >
                    <?php 
                    if(isset($_GET['Inscription'])){
                        if($erreur == 'mail'){
                            echo '<div class="w3-panel w3-red"> <p>Mail non conforme</p> </div>';
                        }
                        else if ($erreur == "mailexiste"){
                            echo '<div class="w3-panel w3-red"> <p>Mail déjà utilisé</p> </div>';
                        }
                    }
                    ?>
                    <label>Mot de passe:</label>
                    <input class ="w3-input w3-border " type="password" name="mdp" required >
                

                    <input  class= "w3-2020-navy-blazer w3-margin w3-btn w3-round-xxlarge w3-hover-white w3-border w3-border-black" type="submit" value="S'inscrire">
                    <p > Déjà client ? </p>
                    <a class="w3-margin <?=$color?> w3-btn w3-round-xxlarge w3-hover-white w3-border w3-border-black" href="Connexion.php"> Connexion </a> 
                
                    </div>
                </form> 
            </div>
        </div>
    </body>
</html>
