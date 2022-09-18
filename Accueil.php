		<?php include_once("Header.php"); ?>
		<?php include("Connexion/ConnexionBD.php"); ?>

			<div class="w3-content w3-cell" style="max-width:1920px">
				<!-- Pub produit -->
				<div class="w3-display-container w3-margin-bottom">
					<?php
						include_once("Informations/InfoAccueil.php");
					?>
				</div>


				<!-- Articles activités entreprise -->
				<div class="w3-row-padding w3-margin-top">
					<div class="w3-third">
						<fieldset class="card">
							<legend class="w3-container w3-xlarge">Economie circulaire</legend>
							<div class="container">
								<img  class="w3-image w3-hover-opacity w3-border w3-round-large image" src="./Images/ecoCirculaire.jpg" style="height:35em;width:50em" alt="">
								<div class="overlay">
									<div class="text">L'économie circulaire est un modèle économique visant à produire des biens et services tout en réduisant le gaspillage 
										des ressources et les déchets.</div>
								</div>
							</div>
						</fieldset>
					</div>

					<div class="w3-third">
						<fieldset class="card">
							<legend class="w3-container w3-large">Matériaux</legend>
							<div class="container">
								<img  class="w3-image w3-hover-opacity w3-border w3-round-large" src="./Images/recyclage.jpg" style="height:35em" alt="">
								<div class="overlay">
									<div class="text">Notre entreprise reprend vos appareils usagés afin de recycler les matériaux. Nous récupérons les composants toujours en état et les métaux précieux pour tout réutiliser.</div>
								</div>
							</div>
						</fieldset>
					</div>

					<div class="w3-third">
						<fieldset class="card">
							<legend class="w3-container w3-xlarge">Reconditionnement</legend>
							<div class="container">
								<img  class="w3-image w3-hover-opacity w3-border w3-round-large" src="./Images/reconditionnement.jpg" style="height:35em" alt="">
								<div class="overlay">
									<div class="text">Le reconditionnement est un processus de remise en état d'un appareil électronique. Cela permet aux clients de faire des économies en achetant des produits moins cher, et à l'entreprise de moins polluer en réutilisant le maximum de composants / matières non abimés.</div>
								</div>
							</div>
						</fieldset>
					</div>
				</div><?php include_once("Footer.php"); ?>
			</div>
		<?php mysqli_close($db); ?>
	</body>
</html>
