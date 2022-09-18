<?php // Réaliser par Lucas JUSTINE?>

<?php if($resultatHistoriqueVente != null):
$date = $resultatHistoriqueVente[0]['date'];?>
<div onclick="Reveal('<?=$date?>')" class="w3-button w3-block w3-black w3-left-align  w3-padding-16"> 
    Vente du  <?=$date?>
    <div class="w3-right" >
        <span > <i class='fa fa-angle-double-down  '></i></span> 
    </div>
</div>

<div id=<?=$date?> class="w3-hide ">
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
foreach($resultatHistoriqueVente as $resultatHistoriqueVentes => $value):
    if($value['date'] == $date): ?>
        <tr>
            <td><img src="Images/Produits/<?=$value['idProduit']?>.jpg" alt="" class="w3-image" style="max-height: 15vh "> <br> <?=$value['name']?></td>
            <td><?=$value['nom']?></td>
            <td>1</td>
            <td><?=$value['date']?></td>
        </tr>
    <?php else:?>
        </table>
        </div>
        <?php $date = $value['date'] ?>
        <div onclick="Reveal('<?=$date?>')" class="w3-button w3-block w3-black w3-left-align  w3-padding-16"> 
            Vente du  <?=$date?>
            <div class="w3-right" >
                <span > <i class='fa fa-angle-double-down  '></i></span> 
            </div>
        </div>
        <div id=<?=$date?> class="w3-hide">
        <table class="w3-table">
            <thead>
                <tr>
                    <th>Objet</th>
                    <th>Entreprise</th> 
                    <th>Quantité</th>
                    <th>Date</th> 
                </tr> 
            </thead>
            <tr>
            <td><img src="Images/Produits/<?=$value['idProduit']?>.jpg" alt="" class="w3-image" style="max-height: 15vh "> <br> <?=$value['name']?></td>
            <td><?=$value['nom']?></td>
            <td>1</td>
            <td><?=$value['date']?></td>
            </tr>
         <?php 
      
        endif ;
      endforeach;?>
</table>
        </div>
<?php else : ?>
    <div class="w3-container w3-center">
        <p> Vous n'avez pas encore de vente </p>
    </div>
<?php endif?>