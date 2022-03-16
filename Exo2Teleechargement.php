<!DOCTYPE html>
<html>

<head>

	<title>Exo2TeleechargementHypermedia</title>

</head>

<body>
	<form action="Exo2Teleechargement.php" , method="post" , enctype="multipart/form-data">

		<input type="File" , name="Mes_imgs">
		<input type="submit" , name="submit" , value="Telecharger">
	</form>

</body>

</html>

<?php

//connexion à la base de données		
$connexion = mysqli_connect('localhost', 'root', '');
mysqli_select_db($connexion, 'hypermedia');
if (isset($_FILES['Mes_imgs'])) {


	$titre_image = $_FILES['Mes_imgs']['name'];
	$type_image = $_FILES['Mes_imgs']['type'];
	$chemin_image = $_FILES['Mes_imgs']['tmp_name'];
	$taille_image = $_FILES['Mes_imgs']['size'];
	$new_img_path = "NewImages/".$_FILES['Mes_imgs']['name'];
	
	$Err = $_FILES['Mes_imgs']['error'];

	//Vérification des erreurs	
	if ($Err == 0) {
		//Vérification de la taille de l'image si elle est sup à 8000 afficher le message

		if ($taille_image > 8 * 1024 * 1024) {
			echo " l'image ne peut être téléchargé, la taille de l'image est innacceptable";
		}
		//Sinon renvoyer l'extension de l'image 
		else {
			$Extension_image = pathinfo($titre_image, PATHINFO_EXTENSION);
			//echo($Extension_image);
			//conversion du titre de l'image en minuscule 
			$conversion = strtolower($Extension_image);
			$FormatExtension_acceptee = array("jpeg", "png", "jpg");

			//Vérification du format de l'image 
			if (in_array($conversion, $FormatExtension_acceptee)) {
				//renvoyer le dossier de destination de l'image à téléverser
				
				//Téléverser l'image dans le dossier de destination NewImages
				move_uploaded_file($chemin_image, $new_img_path);


				//Inserer les valeurs d'images dans la base de données
				$requete_sql = "INSERT INTO images_db (Nom, Format, Url) VALUES ('" . $titre_image . "','" . $type_image . "', '" . $new_img_path . "')";
				if (mysqli_query($connexion, $requete_sql)) {
					echo ('enregistrement effectué');
				}
				echo ("L'image est téléchargée avec succès. '<br/>'");
				//sinon
			} else {
				echo ("Le téléchargement de l'image à échoué");
			}
		}
	}
}



?>