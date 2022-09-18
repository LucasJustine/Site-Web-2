<?php // Réaliser par Lucas JUSTINE?>

<?php 
require("Header.php");


if(isset($_GET['erreur'])){
    $erreur = $_GET['erreur'];
}
?>      <div></div>
         <div class=" w3-row-padding w3-padding-16">
            <h1> Panier </h1>
            <form action="Modification.php" method="post"> 
                <table class="w3-table w3-bordered">
                    <thead>
                        <tr>
                            <th></th>
                            <th >Quantité</th>
                            <th>Entreprise</th>
                            <th>Prix</th>
                            <th>Prix total</th>
                            <th></th>
                            <th style="display:none"></th>
                            <th style="display:none"></th>
                            <th style="display:none"></th>
                            <th style="display:none"></th>
                            <th style="display:none"></th>
                        </tr>
                    </thead>
                    <?php
                    if(isset($_SESSION['panier']) && compterArticles() != 0):
                        $true = "block";
                        $nbArticles=count($_SESSION['panier']['id']);
                        for ($i=0 ;$i < $nbArticles ; $i++): 
                            $id = $_SESSION['panier']['id'][$i];
                            $idEntreprise = $_SESSION['panier']['Entreprise'][$i];
                            $get = $id.",".$idEntreprise;
                            $Prix = $tableauNom[$id][$idEntreprise]["price"];
                            $Max = $tableauNom[$id][$idEntreprise]["max"];
                            $nomProduit = $tableauNom[$id][$idEntreprise]["name"];
                            $Qte = $_SESSION['panier']['QteProduit'][$i];
                            $nomEntreprise = $tableauNom[$id][$idEntreprise]["nomEntreprise"];
                        ?> 
                        <tr>   
                            <td> <img src="Images/Produits/<?=$id?>.jpg" alt="produit" style="max-width:20vh"> 
                                <p><?=$nomProduit?></p>
                            </td>
                            <td   style="display:none"><input type="hidden" name="Modification[<?=$i?>][]" value="<?=$id?>"></td>
                            <td  style="vertical-align: middle;" ><input type="number"  name="Modification[<?=$i?>][]" min="1" max=<?=$Max?> value=<?=$Qte?>></td>
                            <td  style="display:none"><input type="hidden" name="Modification[<?=$i?>][]" value="<?=$idEntreprise?>"></td>
                            <td  style="display:none"><input type="hidden" name="Modification[<?=$i?>][]" value="<?=$Max?>"></td>
                            <td  style="vertical-align: middle;" > <?= $nomEntreprise?></td>
                            <td  style="vertical-align: middle;" > <?= $Prix?></td>
                            <td  style="vertical-align: middle;" > <?= $Prix* $Qte?></td>
                            <td  style="vertical-align: middle;" ><a href="<?="Modification.php?id=".$get?>"  class="w3-btn w3-padding <?=$color?>">Supprimer</a> </td>
                        </tr>
                    <?php endfor;?>
                           
                    <?php  else:
                        $true = "none";
                    ?>
                    <tr>
                       <td colspan="5" class="w3-center">Votre panier est vide</td>
                    </tr>
                    <?php endif;?>   
                </table>
                <div class="w3-container  w3-right" style="display: <?=$true?>" >
                <p> Le montant total est de <?=$MontantGlobal?> euros </p>
                    <div class="w3-row-padding">
                        <input type="submit" name ="Modifier" value="Modifier" style="display: none;" class="w3-col s5 w3-btn <?=$color?> w3-padding w3-animate-left ">
                        <a href="Acheter.php" class="w3-col s5 w3-margin-left w3-btn w3-padding <?=$color?> " > Acheter </a>
                    </div>
                </div>
            </form>
           
            <?php if(isset($erreur)){
                 switch($erreur){
                    case 1:
                      echo '<div class="w3-panel w3-red"> <p>Vous n\'avez pas assez d\'argent </p> </div>';
                      break;

                    case 2:
                      echo '<div class="w3-panel w3-red"> <p>N\'essayez pas d\'acheter plus de produit que possible</p> </div>';
                      break;
                    }
                  } ?>
        </div>
        <script>
            // Quand on clique sur les nombres, on peut les modifiers
            var Modifier = document.querySelectorAll('input');
            for(const Modifiers of Modifier){
                Modifiers.addEventListener('change', Update);
            }  
            function Update(){
                document.getElementsByName('Modifier')[0].style.display = "block";
            }
        </script>
    </body>

</html>