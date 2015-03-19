<?php 
// on récupère l'id de l'article à travers la var GET
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// on forge la requete SQL
$sql = "SELECT * FROM article WHERE id=".$id;

// on passe la requete SQL à PDO
$statement = $db->query($sql);

// on récupère le premier (et unique) résultat de la requete
// si on a un article on l'affiche

//if ($article = $statement->fetchObject("Article")) {
$statement->setFetchMode(PDO::FETCH_CLASS, "Article");

if ($article = $statement->fetch()) {
    
// on affiche l'article 
?>
<h2>Lecture d'un article</h2>



<article id="<?php echo $article->id; ?>">
	<h1><?php echo $article->title; ?></h1>
	<p><?php echo nl2br($article->content); ?></p>
</article>

<?php 
// sinon on affiche un message d'erreur
} else {
	echo "<h2>Aucun article avec cet identifiant.</h2>";
}