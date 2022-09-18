<?php // Réaliser par Lucas JUSTINE?>

<?php 
//Tableau de nom 

if(isset($_SESSION['panier'])){
    $tableauNom = array();
    $requeteNom  = "Select TypeItem.name,price,quantity,Business.name as nomEntreprise 
                    from BusinessSell join Business on BusinessSell.business = Business.id 
                    join TypeItem on BusinessSell.typeItem = TypeItem.id
                    where TypeItem.id = ? and Business.id = ?";
    $stmtNom = mysqli_prepare($db,$requeteNom);
    $MontantGlobal = 0;
    $nbArticles=count($_SESSION['panier']['id']);
    for ($i=0 ;$i < $nbArticles ; $i++){
        mysqli_stmt_bind_param($stmtNom,"ii",$_SESSION['panier']['id'][$i],$_SESSION['panier']['Entreprise'][$i]);
        mysqli_stmt_execute($stmtNom);
        $resultNom=mysqli_stmt_get_result($stmtNom);
        $resultatNom= mysqli_fetch_assoc($resultNom);
        if(!isset($tableauNom[$_SESSION['panier']['id'][$i]][$_SESSION['panier']['Entreprise'][$i]])) // Comme ça il le fais que une fois comme je l'appelle dans acheter aussi 
        $tableauNom[$_SESSION['panier']['id'][$i]][$_SESSION['panier']['Entreprise'][$i]] = array("name" => $resultatNom['name'],"price" => $resultatNom['price'],"max" => $resultatNom['quantity'],"nomEntreprise" => $resultatNom['nomEntreprise']);
        $MontantGlobal = $MontantGlobal + $resultatNom['price'] * $_SESSION['panier']['QteProduit'][$i];
    } 
}   
?>