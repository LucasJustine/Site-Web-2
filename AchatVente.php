<?php // Réaliser par Lucas JUSTINE?>

<?php require("Header.php");?>
<div class=" w3-row-padding w3-padding-16">
    <div class = "w3-content " style="max-width:50% ">
        <div class="w3-row">
            <div class="w3-col l6 w3-container ">
                <img src="Images/Produits/<?=$resultat[0]['id']?>.jpg" style="width: 100%;padding:4px" alt="">
            </div>
            <div class="w3-container w3-col l6" >
                <fieldset class="w3-padding-16">
                    <legend><h1><?= $Titre?> </h1></legend>
                <h2> <?=$nom?></h2>
                <div class="w3-responsive w3-margin">
                    <table class="w3-table-all w3-hoverable">
                    <thead>
                        <tr>
                            <th>Caractéristiques</th>
                            <th></th>
                        </tr>
                    </thead>
                    <?php foreach($resultat as $sousresultats => $sousvalue):?>
                        <tr><td><?=$sousvalue['attribute'] ?></td> 
                        <td><?=$sousvalue['value'] ?></td></tr>
                    <?php endforeach ?>
                    </table>
                </div>  
                <?php   
                if(isset($_POST['Acheter'])):?>
                    <div class="w3-row">
                        <div class="w3-col s6" >
                            <form action="AjouterPanier.php" class="w3-container" method="post">
                                <label> Nombre de produit</label> <br>
                                <input type="number" name=Produit[NB] min="1" max= <?=$Nombre?> value="1" style="width:50%"   required ><br><br>
                                    
                                <label>Entreprise:</label>
                                <select name=Produit[business] class="w3-margin-bottom">
                                <?php foreach($resultatProduit as $sousresultats => $sousvalue):?>
                                    <option value="<?=$sousresultats?>"><?=$sousvalue['name']?></option>
                                <?php endforeach?>
                                </select> <br>
                                <input type="hidden"  name=Produit[IdEntreprise] value=<?=$IdEntreprise?>>
                                <input type="hidden"  name=Produit[id] value=<?=$id?>>
                
                                <input type="submit" name="submit" class="w3-btn <?=$color?>" value="Ajouter au panier">
                            </form>
                        </div>
                        <div class="w3-col s6" >
                            <p>Prix : <b><span id="Achat"></span></b></p>  <!-- J'aurais pû mettre un <p> pour Achat et Vente en meme temps pour le texte mais avec un chacun
                                                                            c'est plus lisible -->
                            <p><b>Localisation :</b>  <span id="Pays"><?=$resultatProduit[0]['country']?></span></p> 
                        </div>  
                    </div>
                </fieldset>            
            </div>
                <?php else : ?>
                    <div class="w3-row">
                        <form action="VenteProduit.php" class="w3-container " method="post">
                            <div>
                                <label>Entreprise:</label><br>
                                <select name="Vente[business]" class="w3-margin-bottom">
                                <?php foreach($resultatVente as $sousresultats => $sousvalue):?>
                                    <option value="<?=$sousresultats?>"><?=$sousvalue['name']?></option>
                                <?php endforeach?>
                                </select> 
                                <p><b>Localisation :</b>  <span id="Pays"><?=$resultatVente[0]['country']?></span></p> 
                            </div>
                            <br>
                            <h2>Etat du téléphone </h2>
                            <p>
                            <input class="w3-radio" type="radio" name="Vente[prix]" value="<?= $priceSell?>" checked >
                            <label>Parfais état </label></p>
                            <p>
                            <input class="w3-radio" type="radio" name="Vente[prix]" value="<?= round($priceSell*0.75,0,PHP_ROUND_HALF_UP) ?>" >
                            <label>Bon état </label></p>
                            <p>
                            <input class="w3-radio" type="radio" name="Vente[prix]" value="<?= round($priceSell*0.25,0,PHP_ROUND_HALF_UP)?>"  >
                            <label>Mauvais état</label></p>
                            <input type="hidden"  name=Vente[id] value=<?=$id?>>
                            <input type="hidden"  name=Vente[IdEntreprise] value=<?=$IdEntreprise?>>
                            <div class="">
                                <p id="Vente"></p>
                            </div> 
                            <input type="submit" name="submit" class="w3-btn <?=$color?>" value="Confirmer">
                        </form>
                    </div>
                </fieldset>            
            </div>
            <?php endif ?>
        </div>
    </div>
</div>
    <script>
        <?php if(isset($_POST['Acheter'])):?>
            var resultatProduit =  <?php echo json_encode($resultatProduit)?>; // Permet de transférer un tableau PHP en javascript 
            var quantiteChoisi = document.getElementsByName('Produit[NB]')[0].value; //Récupere la quantité choisi pour un Produit
            var prix = document.getElementsByName('Produit[NB]')[0].value * resultatProduit[0]['price'] ;    //Initialise le texte pour la 1ere fois 
            document.getElementById('Achat').innerHTML = prix + " euros";    // Affiche le prix 
            document.getElementsByName('Produit[NB]')[0].addEventListener('change',updateValue);  // Ajoute un ecouteur du input permettant d'augmenter dynamiquement le prix en fonction du nombre choisi
            if(resultatProduit[0]['quantity']  == 0){
                document.getElementsByName('submit')[0].disabled = true;
                document.getElementById('Achat').textContent= `Désolé vous ne pouvez plus acheter ce produit`;
            }
            else{
                document.getElementsByName('submit')[0].disabled = false;
            }
            function updateValue() { 
                quantite = this.value;
                document.getElementById('Achat').textContent  = prix * quantite + " euros";
            }

            const Entreprise = document.getElementsByName('Produit[business]')[0]; // Le premier element avec ce nom
            Entreprise.addEventListener('change',EntrepriseChanger);
            function EntrepriseChanger() { 
                var x = this.value ;
                prix  = resultatProduit[x]['price'];    // Prix dans le tableau en fonction de l'entreprise choisi 
                IdEntreprise  = resultatProduit[x]['id'];    // Prix dans le tableau en fonction de l'entreprise choisi 
                quantiteMax = resultatProduit[x]['quantity'];  // Quantité dans le tableau en fonction de l'entreprise choisi 
                Pays = resultatProduit[x]['country'];  // Quantité dans le tableau en fonction de l'entreprise choisi
                quantiteChoisi = document.getElementsByName('Produit[NB]')[0].value;  // Je suis obligé de revérifier la valeur de l'input number pour le calcul 
                if(quantiteMax <= 0){
                    document.getElementsByName('submit')[0].disabled = true;
                    document.getElementById('Achat').textContent= `Désolé vous ne pouvez plus acheter ce produit`;
                }
                else{
                    document.getElementsByName('submit')[0].disabled = false;
                    document.getElementById('Achat').textContent  = prix * quantiteChoisi + " euros";
                    document.getElementById('Pays').textContent  = Pays;
                }
              
                document.getElementsByName('Produit[NB]')[0].setAttribute("max",quantiteMax);  // Met à jour la quantité max pour l'input 
                document.getElementsByName('Produit[IdEntreprise]')[0].setAttribute("value",IdEntreprise);             
            }



        <?php endif ?>
        <?php if(isset($_POST['Vendre'])):?>
        var resultatProduit =  <?php echo json_encode($resultatVente)?>; // Permet de transférer un tableau PHP en javascript 
        var radioButtons = document.querySelectorAll('input[name="Vente[prix]');
        var prixBouton = radioButtons[0].value;
        document.getElementById('Vente').innerHTML= `Nous pouvons reprendre l'appareil ${prixBouton} euros`;  //Initialise le texte pour la 1ere fois
        if(resultatProduit[0]['quantity']  == 0){
            document.getElementsByName('submit')[0].disabled = true;
            document.getElementById('Vente').innerHTML= `Désolé nous ne pouvons plus reprendre ce produit`;
        }
        else{
            document.getElementsByName('submit')[0].disabled = false;
            document.getElementById('Vente').innerHTML= `Nous pouvons reprendre l'appareil ${prixBouton} euros`;
        
            for(const radioButton of radioButtons){
                radioButton.addEventListener('change', Selectionner);
            }   
            function Selectionner(e) {
                if (this.checked) {
                    prixBouton = this.value;
                    document.getElementById('Vente').innerHTML = `Nous pouvons reprendre l'appareil ${prixBouton} euros `;
                }
            }
        }
        const Entreprise = document.getElementsByName('Vente[business]')[0]; // Le premier element avec ce nom
        Entreprise.addEventListener('change',EntrepriseChanger);
        function EntrepriseChanger() { 
            var x = this.value ;
            prix  = resultatProduit[x]['price']; 
            quantiteMax  = resultatProduit[x]['quantity'];  
            Pays = resultatProduit[x]['country'];  
            IdEntreprise  = resultatProduit[x]['id'];    // Prix dans le tableau en fonction de l'entreprise choisi 
            if(quantiteMax == 0){

                document.getElementsByName('submit')[0].disabled = true;
                document.getElementById('Vente').innerHTML= `Désolé nous ne pouvons plus reprendre ce produit`;
            }
            else{
                document.getElementsByName('submit')[0].disabled = false;
                document.getElementById('Vente').innerHTML = `Nous pouvons reprendre l'appareil ${quantiteMax}  euros `;
                document.getElementById('Pays').textContent  = Pays;
                radioButtons[0].setAttribute("value",prix);  // Met à jour la quantité max pour l'input      
                radioButtons[1].setAttribute("value",Math.round(prix * 0.75));  // Met à jour la quantité max pour l'input   Math.round arrondi au nombre le plus proche          
                radioButtons[2].setAttribute("value",Math.round(prix * 0.25) );  // Met à jour la quantité max pour l'input
                for(var i = 0; i < radioButtons.length; i++){
                    if(radioButtons[i].checked){
                        prixBouton = radioButtons[i].value;
                    }
                }
                document.getElementsByName('Vente[IdEntreprise]')[0].setAttribute("value",IdEntreprise);  
                document.getElementById('Vente').innerHTML = `Nous pouvons reprendre l'appareil ${prixBouton} euros `;      
            }
        } 

        <?php endif ?>
    </script>
</body>
