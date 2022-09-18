<?php // Réaliser par Lucas JUSTINE?>

<?php 
    if(isset($_POST['Acheter'])){
        $Titre = "Acheter";
        $id = $_POST['Acheter'];
    }
    else if(isset($_POST['Vendre'])){
        $Titre = "Vendre";
        $id = $_POST['Vendre'];
    }
    else{                   //Si l'utilisateur change le name du bouton redirection 
        header('Location:Produit.php?erreur=1');
        exit();
    }

    $requete = "Select id,name,attribute,value from TypeItem left join TypeItemDetails on TypeItem.id = TypeItemDetails.typeItem where id = ?";
    $stmtObjet = mysqli_prepare($db,$requete);
    mysqli_stmt_bind_param($stmtObjet,"i",$id);
    mysqli_stmt_execute($stmtObjet);
    $res=mysqli_stmt_get_result($stmtObjet);
    $resultat = mysqli_fetch_all($res,MYSQLI_ASSOC);
    if($resultat == null){      // Si l'utilisateur modifie la valeur du bouton et que l'id ne correspond à aucun alors redirection 
        header('Location:Produit.php?erreur=2');
        exit();
    }
    $nom = $resultat[0]['name']; //Nom de l'objet 

    if(isset($_POST['Acheter'])){
        $requeteAchat = "Select quantity,price,name,country, business as id from BusinessSell join Business on BusinessSell.business = Business.Id where TypeItem = ?";
        $stmtAchat = mysqli_prepare($db,$requeteAchat);
        mysqli_stmt_bind_param($stmtAchat,"i",$id);
        mysqli_stmt_execute($stmtAchat);
        $res=mysqli_stmt_get_result($stmtAchat);
        $resultatProduit = mysqli_fetch_all($res,MYSQLI_ASSOC);
        $IdEntreprise = $resultatProduit[0]['id'];
        $Nombre = $resultatProduit[0]['quantity'];
        $priceBuy = $resultatProduit[0]['price'];
        $nombre = mysqli_query($db,"Select FOUND_ROWS()"); 
       
    }
    
    if(isset($_POST['Vendre'])){
        $requeteVente = "Select price,name,quantity,country ,business as id from BusinessBuy join Business on BusinessBuy.business = Business.Id where TypeItem = ?";
        $stmtVente= mysqli_prepare($db,$requeteVente);
        mysqli_stmt_bind_param($stmtVente,"i",$id);
        mysqli_stmt_execute($stmtVente);
        $res=mysqli_stmt_get_result($stmtVente);
        $resultatVente = mysqli_fetch_all($res,MYSQLI_ASSOC);
        $priceSell = $resultatVente[0]['price'];
        $IdEntreprise = $resultatVente[0]['id'];
    }
?>