<?php 
// Realiser par Lucas JUSTINE

//Aider du code et de l'explication du site  https://jcrozier.developpez.com/articles/web/panier/
// Pour faire quelque chose de plutôt propre
// J'ai modifié le code pour qu'il fonctionne en fonction de la présence de id de l'objet ainsi que de l'entreprise
// Car un meme objet peut etre vendu par plusieurs entreprises 


function creationPanier(){
    if(!isset($_SESSION['panier'])){
        $_SESSION['panier'] = array();
        $_SESSION['panier']['id']  = array();
        $_SESSION['panier']['Entreprise']  = array();
        $_SESSION['panier']['QteProduit']  = array();
    }
    return true;
}

function ajouterAuPanier($id,$entreprise,$quantite,$prix,$max){
    // Si le panier existe on va chercher la position du produit 
    if(creationPanier()){
        $positionProduit = array_search($id,  $_SESSION['panier']['id']);
        //Donc si le produit existe on va regarder si le nom de l'entreprise correspond 
        if ($positionProduit !== false)
        {  
            $Entreprise  = $_SESSION['panier']['Entreprise'][$positionProduit];
            // Si le nom de l'entreprise est le meme on augmente seulement la quantité 
            if($entreprise == $Entreprise){
                $_SESSION['panier']['QteProduit'][$positionProduit] += $quantite ;
            }
             // Sinon on ajoute le produit entier 
            else{
                array_push( $_SESSION['panier']['id'],$id);
                array_push( $_SESSION['panier']['Entreprise'],$entreprise);
                array_push( $_SESSION['panier']['QteProduit'],$quantite);

            }
            
        }
        // Sinon on ajoute le produit 
        else{
            array_push( $_SESSION['panier']['id'],$id);
            array_push( $_SESSION['panier']['Entreprise'],$entreprise);
            array_push( $_SESSION['panier']['QteProduit'],$quantite);
        }
       
    }

    else 
        echo " Probleme avec Ajout ";
}


function SupprimerArticle($id,$entreprise){
    // On ne peut faire cette fonction que si le panier existe 
    if (creationPanier()) {
      //Nous allons passer par un panier temporaire pour ne pas avoir de trou dans le panier pour l'affichage surtout 
      $tmp=array();
      $tmp['id'] = array();
      $tmp['Entreprise'] = array();
      $tmp['QteProduit'] = array();
    //On compte le nombre d'élément 
      for($i = 0; $i < count($_SESSION['panier']['id']); $i++)
      { 
         if ($_SESSION['panier']['id'][$i] !== $id || strcmp($_SESSION['panier']['Entreprise'][$i], $entreprise) !== 0)
         {
            array_push( $tmp['id'],$_SESSION['panier']['id'][$i]);
            array_push( $tmp['Entreprise'],$_SESSION['panier']['Entreprise'][$i]);
            array_push( $tmp['QteProduit'],$_SESSION['panier']['QteProduit'][$i]);
         }

      }
      $_SESSION['panier'] = $tmp;
      unset($tmp);
    }
    else
        echo 'probleme avec Supprimer';
}

function modifierQTeArticle($id,$quantite,$entreprise,$max){
    //Si le panier existe
    if (creationPanier()){
       //Si la quantité est positive on modifie sinon on supprime l'article
       if ($quantite > 0 ){
            if($quantite <= $max){
                //Recherche du produit dans le panier
                $positionProduit = array_search($id,  $_SESSION['panier']['id']);
                if ($positionProduit !== false){ 
                    $Entreprise  = $_SESSION['panier']['Entreprise'][$positionProduit];
                    // Si le nom de l'entreprise est le meme on augmente seulement la quantité 
                    if(strcmp($entreprise,$Entreprise == 0)){
                        $_SESSION['panier']['QteProduit'][$positionProduit] = $quantite ;
                    }
                }
            }
        else
            header('Location:Panier.php?erreur=2');
       }
       else{
        supprimerArticle($id,$entreprise);
       }
    }
    else
        echo "Bug avec modifier";
}

/*function MontantGlobal(){
    $total=0;
    for($i = 0; $i < count($_SESSION['panier']['id']); $i++)
    {
       $total += $_SESSION['panier']['QteProduit'][$i] * $_SESSION['panier']['prix'][$i];
    }
    return $total;
}*/


function compterArticles()
{
   if (isset($_SESSION['panier']))
   return count($_SESSION['panier']['id']);
   else
   return 0;
}

function supprimePanier(){
    unset($_SESSION['panier']);
}
/*
function AcheterPanier($Argent) {
    if($Argent < MontantGlobal() ){
        header('Location:Panier.php?erreur=1');
        exit();
    }
}*/

?>