<?php

addMessage(0,"valid","Votre inscription a bien été prise en compte.");

if ($_FILES['photo_profil']['error']==UPLOAD_ERR_OK) {

	// on définit le chemin final du fichier une fois déplacé
	$uploaddir =  'photos/';
	$uploadfile = $uploaddir . basename($_FILES['photo_profil']['name']);

	// on peut vérifier l'extension du fichier
	// tableau regroupant les extensions autorisées
	$autorises =  array('gif','png' ,'jpg');

	// on récupère le nom original du fichier
	$nomFichier = $_FILES['photo_profil']['name'];

	// on extrait l'extension à partir du nom du fichier
	$ext = strtolower(pathinfo($nomFichier, PATHINFO_EXTENSION));

	// on regarde si l'extension est autorisée
	if(!in_array($ext,$autorises) ) {
	    addMessage(1,"error","Extension non autorisée.");
	} else {

		// on tente de déplacer le fichier vers son emplacement final
		// si ca marche, on prévient l'utilisateur
		if (move_uploaded_file($_FILES['photo_profil']['tmp_name'], $uploadfile)) {
		    addMessage(0,"valid","Le fichier est valide, et a été téléchargé avec succès.");
		} else { // sinon on affiche le code erreur
		    addMessage(2, "error", "Erreur détectée.");
		}
	}
}

header("Location: index.php");