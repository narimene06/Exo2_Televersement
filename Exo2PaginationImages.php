<!DOCTYPE html>
<html >
<head>

  <title>Exo2PaginationHypermedia</title>
  
</head>
<body>

<?php
// connecxion à la base de données
$connexion = mysqli_connect('localhost','root','');
mysqli_select_db($connexion, 'hypermedia');

// initialisation de nombre d'éléments à afficher par page
$resultats_ch_page = 2;

// afficher le nombre d'enregistrements figurant  dans la base de données 
$sql='SELECT * FROM images_db';
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
?>

<table>
	<tr>
		<th>Nom </th>
		<th>Format </th>
		<th>Image</th>
	</tr>
			  

<?php
//Tant que y a une ligne retrouvé depuis la bd ensuite l'afficher
while($row = mysqli_fetch_array($resultat)) { 
?>
	<tr>
		<td><?php echo $row['Nom']; ?></td>
		<td><?php echo $row['Format']; ?></td>
		<td> <img src="<?php echo $row['Url']; ?>" width="150" height="150"></img></td>
		
	</tr>
	
<?php  
}?>
</table>
<?php 
// créer des liens entre les pages grace à la balise <a href>
// si le numéro de page est inférieur au nombres de pages qu'on souhaite avoir et qui sont déclarées en haut on incrémente et on fait un lien pour le page suivante. 
for ($page=1;$page<=$nb_pages;$page++) {
  echo '<a href="Exo2PaginationImages.php?page=' . $page . '">' . $page . '</a> ';
}

?>
</body>
</html>