<h2>Ajout/édition d'un utilisateur</h2>

<form method="post" action="index.php?controller=user&action=edit" enctype="multipart/form-data">
    <h2>Ajout/édition d'un utilisateur</h2>

    <fieldset>
        <legend>Etat civil</legend>
        <!-- <label>Titre :
            <select name="titre">
                <option value="mr">M.</option>
                <option value="mme">Mme</option>
                <option value="mlle">Mlle</option>
            </select>
        </label> -->

        <label>Nom complet : 
            <input type="text" name="name" placeholder="Veuillez saisir votre nom" required title="Ici votre nom"
                value="<?php echo $user->name; ?>"></label>

        <label>Date de naissance : 
            <input type="date" name="birth_date" placeholder="YYYY-MM-DD" required
                value="<?php echo $user->birthDate; ?>"></label>


        <!-- Sexe :
        <label>M <input type="radio" name="sexe" value="M"> </label>
        <label>F <input type="radio" name="sexe" value="F"> </label> -->
    </fieldset>

    <fieldset>
        <legend>Identifiants</legend>

        <label>Adresse email : 
            <input type="email"
                   name="email"
                   required
                   onchange="form.email_confirm.pattern = this.value;"
                   title="Adresse email"
                   value="<?php echo $user->email; ?>">
        </label>

        <label>Confirmer l'adresse email :
            <input type="email"
                   name="email_confirm"
                   required
                   title="Les 2 emails doivent correspondre"
                   value="<?php echo $user->email; ?>">
        </label>

        <label>Identifiant :
            <input type="text" name="login" value="<?php echo $user->login; ?>">
        </label>

        <label>Mot de passe :
            <input type="password" name="password" value="<?php echo $user->password; ?>">
        </label>

        <label>Confirmer le mot de passe :
            <input type="password" name="password_confirm" value="<?php echo $user->password; ?>">
        </label>

    </fieldset>

    <!-- <fieldset>
        <legend>Informations supplémentaires</legend>

        <label>Téléphone :
            <input type="tel" name="telephone">
        </label>

        <label>Photo de profil :
            <input type="file" name="photo_profil">
        </label>

        <label>Adresse du site :
            <input type="url" name="url_site">
        </label>

        <label>Présentation :
            <textarea name="presentation"></textarea>
        </label>

        <label>S'abonner à la newsletter
            <input type="checkbox" name="newsletter" checked>
        </label>
    </fieldset> -->
    <input type="hidden" name="id" value="<?php echo $user->id; ?>" />
    <input type="submit" name="submit" value="Envoyer" />
</form>