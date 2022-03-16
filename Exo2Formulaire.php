
<!DOCTYPE html>
<html >
<head>

  <title>Exo2FormulaireHypermedia</title>
  
</head>
<body>
	<form action ="Exo2Formulaire.php", method = "post",  enctype="multipart/form-data">
	
	<input type = "File", name ="Mes_imgs"> <br/>
	<input type = "submit", name ="submit", value = "Telecharger">
	</form>
	
	</body>
	</html>
	
<?php

if (isset($_FILES['Mes_imgs'])) {

		$titre_image = $_FILES['Mes_imgs']['name'];
		$type_image = $_FILES['Mes_imgs']['type'];
		$chemin_image = $_FILES['Mes_imgs']['tmp_name'];
		$taille_image = $_FILES['Mes_imgs']['size'];
		$Err = $_FILES['Mes_imgs']['error'];
	//Vérification des erreurs	
		if ($Err == 0){
		//Vérification de la taille de l'image si elle est sup à 8000 afficher le message
			
			if($taille_image > 8*1024*1024){
				echo " l'image ne peut être téléchargé, la taille de l'image est innacceptable";
			}
		//Sinon renvoyer l'extension de l'image 
			else{
				$Extension_image = pathinfo($titre_image, PATHINFO_EXTENSION);
					//echo($Extension_image);
				$conversion = strtolower($Extension_image);
				$FormatExtension_acceptee = array("jpeg", "png");
				
				if (in_array($conversion, $FormatExtension_acceptee))
				{
					$new_img_path = 'NewImages/'.$titre_image;
					move_uploaded_file($chemin_image, $new_img_path);
						echo("L'image est téléchargée avec succès");
						}
				else {
					echo("Le téléchargement de l'image à échoué");
				}
		}
}
}
?>