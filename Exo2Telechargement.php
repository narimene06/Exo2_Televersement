
<!DOCTYPE html>
<html >
<head>

  <title>Exo2TelechargementHypermedia</title>
  
</head>
<body>
	<form action ="Exo2Telechargement.php", method = "post",  enctype="multipart/form-data">
	
	<input type = "File", name ="Mes_imgs">
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
				//conversion du titre de l'image en minuscule 
				$conversion = strtolower($Extension_image);
				$FormatExtension_acceptee = array("jpeg", "png");
				
				//Vérification du format de l'image 
					if (in_array($conversion, $FormatExtension_acceptee))
				{
					//renvoyer le dossier de destination de l'image à téléverser
					$new_img_path = 'NewImages/'.$titre_image;
					//Téléverser l'image dans le dossier de destination NewImages
					move_uploaded_file($chemin_image, $new_img_path);
						echo("L'image est téléchargée avec succès. '<br/>'"); 
				//sinon
					}else {
						echo("Le téléchargement de l'image à échoué");
				}
	//connexion à la base de données		
					
	$connexion = mysqli_connect('localhost','root','');
	mysqli_select_db($connexion, 'hypermedia');
				
	//Inserer les valeurs d'images dans la base de données
	$requete_sql = "INSERT INTO images_db (Nom, Format, Url) VALUES ('".$titre_image."','".$type_image."', '".$chemin_image."')";
		if(mysqli_query($connexion, $requete_sql)) {
			echo ('enregistrement effectué') ;
						}

// initialisation de nombre d'éléments à afficher par page
$resultats_ch_page = 6;

// afficher le nombre d'enregistrements figurant  dans la base de données 
$sql='SELECT * FROM images_db ORDER BY Id ASC';
$resultat = mysqli_query($connexion, $sql);
$nombre_enregistrements = mysqli_num_rows($resultat);



//determiner le nombre de page possible en fonction de nombre d'enregistrement et le nombre d'enregistrement à afficher 
$nb_pages = ceil($nombre_enregistrements /$resultats_ch_page);

// determiner sur quel page y aller 
//Si les variables de la page ne sont pa sdéfini on recçoit 1 sinon on a la page 1,2,3...etc
if (!isset($_GET['page'])) {
  $page = 1;
} else {
  $page = $_GET['page'];
}

// la limite du commencement d'affichages des enregistrement par pages 
$premiers_resultats = ($page-1)*$resultats_ch_page;

// le resultats retourné depuis la bd en respectant la limite défini précédemment.
$sql='SELECT * FROM images_db LIMIT ' . $premiers_resultats . ',' .  $resultats_ch_page;
$resultat = mysqli_query($connexion, $sql);

//Tant que y a une ligne retrouvé depuis la bd ensuite l'afficher
while($row = mysqli_fetch_array($resultat)) { ?>
  <div class="alb">
             	<img src="new_img_path/<?=$chemin_image['Url']?>">
             </div>
<?php 
}

// créer des liens entre les pages grace à la balise <a href>
// si le numéro de page est inférieur au nombres de pages qu'on souhaite avoir et qui sont déclarées en haut on incrémente et on fait un lien pour le page suivante. 
for ($page=1;$page<=$nb_pages;$page++) {
  echo '<a href="Exo2Telechargement.php?page=' . $page . '">' . $page . '</a> ';
}
					
}
}
}

?>