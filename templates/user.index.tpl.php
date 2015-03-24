<?php
if ($users) {
    $nbRows = count($users);

// on affiche l'article 
    ?>
    <h2>Liste des utilisateurs (<?php echo (int) $nbRows; ?>)</h2>
    <ul>
        <?php foreach ($users as $user) { ?>
            <li id="<?php echo $user->id; ?>">
                <a href="index.php?controller=user&action=read&id=<?php echo $user->id; ?>"><?php echo $user->name . " - " .$user->email; ?></a>
                - <a href="index.php?controller=user&action=edit&id=<?php echo $user->id; ?>">edit</a>
                - <a href="index.php?controller=user&action=delete&id=<?php echo $user->id; ?>">delete</a>
            </li>
        <?php
    }
    ?>
    </ul>
        <?php
// sinon on affiche un message d'erreur
    } else {
        ?>
        <h2>Aucun utilisateur.</h2>
        <?php
    }
    ?>
<p><a href="index.php?controller=user&action=edit">Ajouter un utilisateur.</a></p>
