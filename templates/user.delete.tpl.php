<h2>Confirmer la suppression</h2>

<form method="post" action="index.php?controller=user&action=delete">
    <p><strong>Voulez-vous confirmer la suppression de l'utilisateur <?php echo $user->id; ?> ?<strong></p>
                <p>Titre : <?php echo $user->name; ?></p>
                <input type="hidden" name="id" value="<?php echo $user->id; ?>" />
                <input type="submit" name="confirmer" value="Confirmer" />
                <input type="submit" name="annuler" value="Annuler" />
</form>