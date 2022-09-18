			<?php
				$sql = "SELECT id, name, marque FROM TypeItem T JOIN BusinessSell B ON T.id=B.typeItem NATURAL JOIN TypeItemDetails WHERE quantity IN (SELECT MAX(quantity) FROM BusinessSell)";
				$prod = mysqli_fetch_assoc(mysqli_query($db, $sql));
				if(!$prod)
					echo "Il n'y a pas de produit disponible";
				else {
				$sql2 = "Select name,attribute,value from TypeItem left join TypeItemDetails on TypeItem.id = TypeItemDetails.typeItem where id = ?";
				$stmtObjet = mysqli_prepare($db,$sql2);
				mysqli_stmt_bind_param($stmtObjet,"i",$prod['id']);
				mysqli_stmt_execute($stmtObjet);
				$res=mysqli_stmt_get_result($stmtObjet);
				$prod2 = mysqli_fetch_all($res);
				$nom = $prod2[0][0];
			?>
			<!-- Contenu pub -->
			<img alt="" src="./Images/banTest.jpg" class="w3-image">
			<img alt=""  class="w3-display-left w3-container w3-round-large" style="margin-left:10%" src="./Images/Produits/<?=$prod['id']?>">
		<div class="w3-display-middle w3-container w3-large" style="margin-left:20%">
			<table class="w3-table-all">
				<?php
					foreach($prod2 as $key => $value) {
						echo "<tr>";
						echo "<td>{$value[1]}</td>";
						echo "<td>{$value[2]}</td>";
						echo "</tr>";
					}
				?>
			</table>
		</div>
		<div class="w3-display-bottommiddle w3-container w3-large"><?php echo $prod['name']; ?></div>
		<div class="w3-display-bottomright w3-container w3-large"><?php echo $prod['marque']; ?></div>
			<?php
				}
			?>

