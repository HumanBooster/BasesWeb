<?php 

// on regarde si un ID a été fourni
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// on regarde si un formulaire a été soumis
if (isset($_POST['confirmer'])) {

	// on regarde si un id est passé dans le formulaire, si oui il est prioritaire
	if (isset($_POST['id'])&&$_POST['id']>0)
		$id = (int)$_POST['id'];

	$result = $articleRepo->remove($id);

	// on valide et on redirige
	addMessageRedirect(0,"valid",$result . " article a été supprimé.");
}
// on regarde si notre formulaire a été annulé
else if (isset($_POST['annuler'])) {
	// on ne fait rien et on redirige
	addMessageRedirect(0,"info","La suppression a été annulée.");
}

// si on est jusqu'ici, il n'y a pas eu de redirection
// il faut donc générer un formulaire
// mais d'abord, regardons si on a un article correspondant à l'identifiant demandé
if ($id>0) {
	$article = $articleRepo->get($id);
        
	if (!$article) {
		addMessageRedirect(0,"error","Aucun article trouvé avec cet identifiant.");
	}
}

?>
<h2>Confirmer la suppression</h2>

<form method="post" action="index.php?page=article_delete">
	<p><strong>Voulez-vous confirmer la suppression de l'article <?php echo $id; ?> ?<strong></p>
	<p>Titre : <?php echo $article->title; ?></p>
	<input type="hidden" name="id" value="<?php echo $id; ?>" />
	<input type="submit" name="confirmer" value="Confirmer" />
	<input type="submit" name="annuler" value="Annuler" />
</form>