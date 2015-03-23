<h2>Ajout/édition d'un article</h2>

<form method="post" action="index.php?page=article_edit">
    <label>Title :<input type="text" name="title" value="<?php echo $article->title; ?>" /></label>
    <label>Content:
        <textarea name="content"><?php echo $article->content; ?></textarea>
    </label>
    <input type="hidden" name="id" value="<?php echo $article->id; ?>" />
    <input type="submit" name="submit" value="Envoyer" />
</form>