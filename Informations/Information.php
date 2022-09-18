<?php // Réaliser par Lucas JUSTINE?>

<?php  
    if(isset($_SESSION['id'])) { // Si tu es connecté, on récupère les informations du client
        $requete = "Select firstname,surname,email,login,stash from CustomerProtectedData natural join Customer where  id = {$_SESSION['id']}";
        $res = mysqli_query($db,$requete);
        $resultat = mysqli_fetch_assoc($res);        
        
        $requete2 = "Select image from Customer where id = {$_SESSION['id']}";
        $res2 = mysqli_query($db,$requete2);
        if ($res2)
            $resultatIMG = mysqli_fetch_assoc($res2);
        else 
            $resultatIMG = null;  
    
        $requete = "Select name,Z,quantity from Mendeleiev left outer join (SELECT * from CustomerExtraction where Customer = {$_SESSION['id']}) client on Z = client.element ";
        $res= mysqli_query($db,$requete);
        $ligne = mysqli_fetch_all($res);
    } 
?>  