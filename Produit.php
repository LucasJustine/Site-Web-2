<?php // Réaliser par Lucas JUSTINE?>
<?php

require("Header.php");

if($page > $Pagination + 1){                            // Si l'utilisateur met une page trop élévée alors redirection vers la derniere page produit 
 header("Location:Produit.php?$string&page=$Pagination");
 exit();
}

if(isset($_GET['erreur'])){
  switch($_GET['erreur']){
    case 1:
      $erreur = "Veuillez ne pas changer le name des boutons ";
      break;
    case 2:
      $erreur = "Veuillez ne pas changer la valeur des boutons ";
      break;
    case 3:
      $erreur = "Veuillez ne pas trafiquer le bouton. Impossible de vendre ce produit";
      break;
    case 4:
      $erreur = "Veuillez ne pas trafiquer le bouton. Impossible de d'acheter ce produit";
      break;
    case 5:
      $erreur = "Veuillez ne pas trafiquer les prix de vente.";
      break;
  }
}



$pageSuivante = $page < $Pagination ? $page+1 : $page; 
$pagePrecedente= $page > 1 ? $page-1 : $page;
?>
    <!-- Partie Centrale -->
    <div class=" w3-row-padding w3-padding-16">
      <!-- Partie Gauche -->
      <div class="w3-col filtre  w3-padding-top m3" >

      <form method="get">
        <?php 
          $prixMin = isset($_GET['prix']) ? $_GET['prix'][0] : '0';
          $prixMax = isset($_GET['prix']) ? $_GET['prix'][1] : '5000';
        ?>
      <!-- Filtre Marque -->
        <a onclick="Reveal('Marque')" class="w3-button w3-block w3-black w3-left-align">Marque</a>
        <div id="Marque" class="w3-hide w3-ul w3-animate-zoom">
          <ul class="w3-ul">
            <?php
              foreach($MarqueProduit as $Marque => $valeur): 
              $checked = isset($_GET['marque']) && in_array($valeur[0],$_GET['marque']) ? 'checked' : '';
            ?> 
              <li><input id=<?=$valeur[0] ?> type="checkbox" value=<?=$valeur[0]?> name="marque[]" <?php echo $checked ?>>
              <label for=<?=$valeur[0]?>  ><?=$valeur[0]?></label><br></li>
            <?php endforeach ?>
          </ul>
        </div>

        <!-- Filtre Type -->
        <a onclick="Reveal('Type')" class="w3-button w3-block w3-black w3-left-align">Type</a>
        <div id="Type" class="w3-hide  w3-animate-zoom">
          <ul class="w3-ul">
            <?php foreach($ObjetProduit as $Objet => $valeur): 
                $checked = isset($_GET['objet']) && in_array($valeur[0],$_GET['objet']) ? 'checked' : '';
            ?>
            <li><input type="checkbox" value="<?=$valeur[0]?>" name="objet[]" <?php echo $checked ?>>
            <label > <?=$valeur[0]?> </label></li>
            <?php endforeach ?>
          </ul>
        </div>

      <!-- Filtre Prix -->
        <div id="doubleRange" class="doubleRange" >
          <div class="barre">   
              <div class="barreMilieu" style="width:50%; left:25%;"></div>
              <div class="t1 thumb" style="left:25%"></div>
              <div class="t2 thumb" style="left:75%;"></div>
          </div>
          <div class="label">de <span class="labelMin"></span> à <span class="labelMax"></span></div>
          <input type="hidden" name="prix[]" value="" class="inputMin"/>
          <input type="hidden" name="prix[]" value="" class="inputMax"/>
        </div>
      
        <script src="CSS/doubleRange.js"></script> 
        <script> // Trouver sur internet. Pour le filtre prix en ligne
            setDoubleRange({
                element: '#doubleRange',
                minValue: 0,
                maxValue: 5000,
                maxInfinite: false,
                stepValue: 5,
                defaultMinValue: <?=$prixMin ?>,
                defaultMaxValue: <?=$prixMax ?>,
                unite: '€'
            });
        </script>
      
        <input type='hidden' name='page' value='<?=isset( $_GET['page'] ) ? $_GET['page'] : 1;?>' />
        <div class="w3-row-padding w3-margin-top"> 
          <div class="w3-col m6 w3-center" >  
            <input type="submit" class = "w3-black w3-button" value="Rechercher">
          </div>
          <div class="w3-col m6 w3-center" > 
            <a class = "w3-black w3-button" href="?&page=<?=$page?>"> Supprimer </a>
          </div>
        </div>
        
        </form>
        
      </div>
      
      <!-- Partie Centrale -->
      <div class="w3-col m9  w3-large produit " >
        <div class ="w3-row-padding">
          <?php 
          if(isset($_GET['FiltreMarque']) || isset($_GET['FiltreObjet'])){
            require('Informations/VerificationFiltre.php');
            exit();
          }
          if(isset($erreur)):?>  
            <div class="w3-panel w3-red">
              <p><?=$erreur?></p>
            </div>
          <?php endif?>
        
          <?php foreach($resProduit as $resProduits): ?>
            <div class = "w3-col s6  w3-animate-left "  >
              <fieldset class="w3-padding-16">
                <legend><h3><?= $resProduits['name']?> </h3></legend>
                <div class="w3-center">
                  <img src="Images/Produits/<?=$resProduits['id']?>" class="w3-image"  style="height: 30vh;"  alt="">
                    <div>
                      <span class=" w3-xxlarge w3-margin"><?=$resProduits['price']?><span class="w3-large">,00 €</span></span>
                    </div>
                </div>
                <div class="w3-center">
                  <form action="AchatVente.php" method="post"  class="w3-row-padding">
                    <div class= "w3-half" >
                    <?php 
                      if(!in_array($resProduits['id'],$BusinessSellTab))
                        $desactiver = "disabled"; 
                      else
                        $desactiver = ""; 
                      ?>
                      <button type="submit" value="<?=$resProduits['id']?>" name="Acheter" class="w3-btn w3-hover-light-gray w3-block <?=$color?>" <?=$desactiver?> >Acheter</button>
                    </div>
                    <div class= "w3-half" >
                      <?php 
                      if(!in_array($resProduits['id'],$BusinessBuyTab))
                        $desactiver = "disabled"; 
                      else
                        $desactiver = ""; 
                      ?>
                      <button type="submit" value="<?=$resProduits['id']?>"  name="Vendre" class="w3-btn w3-hover-light-gray w3-block <?=$color?>" <?=$desactiver?> >Vendre</button>
                </div>
                    </form>
                  </div>
              </fieldset>
            </div>
          <?php endforeach;?>  
        </div>

        <!-- Pagination -->
        <div class = "w3-center w3-margin">
          <div class="w3-bar w3-margin-top w3-border">
            <a href='?<?= $string."&page=".$pagePrecedente?>' class="w3-bar-item w3-button">&laquo;</a>
            <?php
            for($i=1;$i<=$Pagination;$i++):?>
              <a href='?<?=$string."&page=".$i?>' class="w3-bar-item w3-button <?php if($_GET['page'] == $i) echo "w3-2020-navy-blazer" ?> "><?=$i?></a>
            <?php endfor ?>
              <a href='?<?= $string."&page=".$pageSuivante?>' class="w3-bar-item w3-button">&raquo;</a>
                
          </div>
        </div>
      </div>

    </div>

    <script>
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
