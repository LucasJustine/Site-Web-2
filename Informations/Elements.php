<?php // Réaliser par Lucas JUSTINE?>

<?php if(isset($_SESSION['id'])) : // Si tu es connecté, on récupère les informations du client?>
        <div class="w3-responsive ">
            <table class="w3-table-all w3-hoverable">
                <thead><tr>
                <th>Element</th>
                <th>Z</th>
                <th class = "w3-center">Quantité (en mg)</th>
                </tr> </thead>
                <?php foreach($ligne as $test):?>
                    <tr>
                    <td> <?= $test[0] ?> </td>
                    <td> <?=  $test[1] ?>  </td> 
                    <?php if ($test[2] != null):?>
                        <td class = "w3-center">  <?= $test[2] ?>  </td> 
                    <?php else : ?>
                    <td class = "w3-center">  0 </td>  
                    </tr>
                    <?php endif ?>
                <?php endforeach; ?>
            </table> 
        </div>
    <?php endif;?> 