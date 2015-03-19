<?php 
// on forge la requete SQL
$sql = "SELECT * FROM article";

// on passe la requete SQL à PDO
$statement = $db->query($sql);

// on récupère le premier (et unique) résultat de la requete
// si on a un article on l'affiche
$statement->setFetchMode(PDO::FETCH_CLASS, "Article");

if ($articles = $statement->fetchAll()) {
	$nbRows = count($articles);

// on affiche l'article 
?>
<h2>Liste des articles (<?php echo (int)$nbRows; ?>)</h2>
<ul>
<?php 
	foreach ($articles as $article) { ?>
<li id="<?php echo $article->id; ?>">
	<a href="index.php?page=article_read&id=<?php echo $article->id; ?>"><?php echo $article->title; ?></a>
	- <a href="index.php?page=article_edit&id=<?php echo $article->id; ?>">edit</a>
	- <a href="index.php?page=article_delete&id=<?php echo $article->id; ?>">delete</a>
</li>
<?php 
	}
?>
</ul>
<?php
// sinon on affiche un message d'erreur
} else {
	echo "<h2>Aucun article avec cet identifiant.</h2>";
}

?>
<p><a href="index.php?page=article_add">Ajouter un article</a></p>