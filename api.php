<form>
	<input type='text' name="s">
	<button name="find">Rechercher</button>
</form>

<?php
if(isset($_GET['s'])){
	$opts = array(
		'http' => array(
			'method' => "GET"
		)
	);
	//
	// Création d'un flux HTTP
	//
	$context = stream_context_create($opts);

	//
	// Execution de la requête de mise a jour et récuperation de la réponse
	//
	$s = urlencode($_GET['s']);
	$films = file_get_contents('http://www.omdbapi.com/?s='.$s.'&plot=short', false, $context);

	//
	// Json_decode en true pour convertir $film en tableau php ( FALSE pour le convertir en OBJET)
	//
	$films = json_decode($films, true);

	// Version propre pour preparer l'affichage de/des films
	function displayFilm($film){
		$output = '<h1>';
		$output .= $film['Title'];
		$output .= "</h1>";
		$output .= "<img src='".$film['Poster']."' alt'".$film['Title']."' />'";
		return $output;
	}
// On fait un foreach pour afficher tt les films
	if($films['Response'] == "True") :
		foreach ($films['Search'] as $film):
			echo displayFilm($film);
		endforeach;
	else:
		echo "Movie not foud";
	endif;
}

?>