<?php // Réaliser par Lucas JUSTINE?>


<?php if($resultatHistorique != null):
$num = $resultatHistorique[0]['NumeroCommande'];?>
<div onclick="Reveal(<?=$num?>)" class="w3-button w3-block w3-black w3-left-align  w3-padding-16"> 
    Commande numéro <?=$num?>
    <div class="w3-right" >
        <span > <i class='fa fa-angle-double-down  '></i></span> 
    </div>
</div>

<div id=<?=$num?> class="w3-hide ">
<table class="w3-table">
    <thead>
        <tr>
            <th>Objet</th>
            <th>Entreprise</th>
            <th>Quantité</th>
            <th >Date</th>
        </tr>
    </thead>

<?php 
foreach($resultatHistorique as $resultatHistoriques => $value):
    if($value['NumeroCommande'] == $num): ?>
        <tr>
            <td><img src="Images/Produits/<?=$value['objet']?>.jpg" alt="" class="w3-image" style="max-height: 15vh "> <br> <?=$value['name']?></td>
            <td><?=$value['nom']?></td>
            <td><?=$value['quantite']?></td>
            <td><?=$value['date']?></td>
        </tr>
    <?php else:?>
        </table>
        </div>
        <?php $num = $value['NumeroCommande'] ?>
        <div onclick="Reveal(<?=$num?>)" class="w3-button w3-block w3-black w3-left-align w3-padding-16"> 
            Commande numéro <?=$num?>
            <div class="w3-right" >
                <span > <i class='fa fa-angle-double-down  '></i></span> 
            </div>
        </div>
        <div id=<?=$num?> class="w3-hide">
        <table class="w3-table">
            <thead>
                <tr>
                    <th>Objet</th>
                    <th>Entreprise</th>
                    <th>Quantité</th>
                    <th >Date</th>
                </tr>
            </thead>
            <tr>
            <td><img src="Images/Produits/<?=$value['objet']?>.jpg" alt="" class="w3-image" style="max-height: 15vh "> <br> <?=$value['name']?></td>
            <td><?=$value['nom']?></td>
            <td><?=$value['quantite']?></td>
            <td><?=$value['date']?></td>
            </tr>
         <?php 
      
        endif ;
      endforeach;?>
</table>
        </div>
<?php else : ?>
    <div class="w3-container w3-center">
        <p> Vous n'avez pas encore de commande </p>
    </div>
<?php endif?>