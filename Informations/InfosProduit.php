
<?php // Réaliser par Lucas JUSTINE?>

<?php
// Permet de savoir sur quelle page on est 
if(isset($_GET['page']) && !empty($_GET['page'])){
    $page = (int) strip_tags($_GET['page']);
}else{
    $page = 1;
}

$MarqueProduit =  mysqli_fetch_all(mysqli_query($db,"select distinct marque from TypeItem")); // Requete pour les marques
$ObjetProduit  =  mysqli_fetch_all(mysqli_query($db,"select distinct Objet marque from Objet")); // Requete pour les objets
$BusinessBuy   =  mysqli_fetch_all(mysqli_query($db,"select TypeItem from BusinessBuy")); // Requete pour les objets
$BusinessSell  =  mysqli_fetch_all(mysqli_query($db,"select TypeItem from BusinessSell")); // Requete pour les objets

 //Permet de mettre le resultat de la recherche des marque dans un tableau à 1 dimension pour la comparaison de l'id dans Produit.php 
foreach($BusinessBuy as $soustableau => $valeursSousTableau){
    foreach($valeursSousTableau as $valeurSousTableau => $valeur ){
        $BusinessBuyTab[] = $valeur;
    }
} 
 //Permet de mettre le resultat de la recherche des marque dans un tableau à 1 dimension pour la comparaison de l'id dans Produit.php 
foreach($BusinessSell as $soustableau => $valeursSousTableau){
    foreach($valeursSousTableau as $valeurSousTableau => $valeur ){
        $BusinessSellTab[] = $valeur;
    }
} 

$nbr_de_items = mysqli_fetch_assoc(mysqli_query($db,"select count(id) as nbr from TypeItem"))['nbr'];
$nbr_elements_par_page=6;
$nbr_de_pages = ceil($nbr_de_items/$nbr_elements_par_page);

$debut=($page * $nbr_elements_par_page) - $nbr_elements_par_page;
$string="";
// Si un filtre est choisi 
$tableau = [];


if(isset($_GET['marque'])){
   //Permet de mettre le resultat de la recherche des marque dans un tableau à 1 dimension pour la comparaison avec le GET 
    foreach($MarqueProduit as $soustableau => $valeursSousTableau){
        foreach($valeursSousTableau as $valeurSousTableau => $valeur ){
            $tableau[] = $valeur;
        }
    } 
    //Verifie si il n'y a pas n'importe quoi dans le GET
    foreach($_GET['marque'] as $Marque => $marque){
        if(!in_array($marque,$tableau)){
            $_GET['FiltreMarque'] = true;
        }
    }
    // Permet de transformer le $_GET en une chaine pour la requete
    $marque = implode('","',$_GET['marque']);
    // La requete where 
    $where = "where marque in (\"" . $marque . "\") ";
    // Transforme le tableau $_GET en url ( Trouver sur internet  https://stackoverflow.com/questions/29376644/how-to-convert-array-to-url-parameter )
    $query = http_build_query($_GET['marque'],"", '&');
    // Comme l'url est mauvais, remplace le mauvais debut en bon 
    $string .= preg_replace('/[0-9]=/i', 'marque[]=', $query);  // Trouver sur internet https://www.w3schools.com/php/func_regex_preg_replace.asp
}    

else {
    // Si aucun filtre n'est choisi, il n'y a pas de where 
    $where=" where 1=1 "; // Permet d'éviter de faire plusieurs if pour savoir si l'on met AND 
}


if(isset($_GET['objet'])){
    //Permet de mettre le resultat de la recherche des marque dans un tableau à 1 dimension pour la comparaison avec le GET 
    foreach($ObjetProduit as $soustableau => $valeursSousTableau){
        foreach($valeursSousTableau as $valeurSousTableau => $valeur ){
            $tableau[] = $valeur;
        }
    } 
    //Verifie si il n'y a pas n'importe quoi dans le GET
    foreach($_GET['objet'] as $Objet => $objet){
        if(!in_array($objet,$tableau)){
            $_GET['FiltreObjet'] =  $tableau;;
        }
    }
    // Permet de transformer le $_GET en une chaine pour la requete
    $objet = implode('","',$_GET['objet']);
    $where .= " and  objet in (\"" . $objet . "\") ";
    $query = http_build_query($_GET['objet'],"", '&');
    // Comme l'url est mauvais, remplace le mauvais debut en bon 
    $string .= "&".preg_replace('/[0-9]=/i', 'objet[]=', $query);  // Trouver sur internet https://www.w3schools.com/php/func_regex_preg_replace.asp
}


if(isset($_GET['prix'])){
    // Permet de transformer le $_GET en une chaine pour la requete
    if($_GET['prix'][0] < 0 )
    $_GET['prix'][0]=0;
    $prix = implode(' and ',$_GET['prix']);
    $where .= "and price between ".$prix." ";
    $query = http_build_query($_GET['prix'],"", '&');
    // Comme l'url est mauvais, remplace le mauvais debut en bon 
    $string .= "&".preg_replace('/[0-9]=/i', 'prix[]=', $query);  // Trouver sur internet https://www.w3schools.com/php/func_regex_preg_replace.asp

}

// prix max et min

$requeteLimit="group by TypeItem.id limit $debut,$nbr_elements_par_page";

$requeteproduit = "select  SQL_CALC_FOUND_ROWS id,name,objet,BusinessSell.price as price from TypeItem 
left join Objet on TypeItem.id = Objet.Item
left join BusinessSell on TypeItem.id = BusinessSell.typeItem ".$where.$requeteLimit; 
//requete 
$resultatProduit = mysqli_query($db,$requeteproduit);
$resProduit = mysqli_fetch_all($resultatProduit,MYSQLI_ASSOC);

if($resProduit == 0){
    $string="";
}
$nombre = mysqli_query($db,"Select FOUND_ROWS()"); 
$nb = mysqli_fetch_assoc($nombre);
// Permet de savoir combien de de page il faut en tout car il ne prend pas en compte la limite 
$Pagination = ceil($nb["FOUND_ROWS()"]/$nbr_elements_par_page);

// J'ai essayé de faire grâce à ce site mais je n'ai pas reussi https://stackoverflow.com/questions/61489368/how-can-i-combine-pagination-and-filtering-in-php
?>


