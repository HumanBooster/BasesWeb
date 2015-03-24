<?php
if ($user) {

// on affiche l'article 
    ?>
    <h2><?php echo $user->name . " - " . $user->email; ?></h2>


    <pre>
        <?php var_dump($user); ?>
    </pre>
    <?php
// sinon on affiche un message d'erreur
} else {
    echo "<h2>Aucun utilisateur avec cet identifiant.</h2>";
}