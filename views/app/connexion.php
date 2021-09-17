<?php include(VIEWS . '_partials/header.php'); ?>

<form method="post" action="<?= BASE_PATH . 'user/connexion' ?>">

    <fieldset>

        <input type="hidden" name="id" value="<?= 0 ?>">

        <div class="form-group">
            <label for="exampleInputEmail1" class="form-label mt-4"> Email </label>
            <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" 
            placeholder="Email">
        </div>
        <input type="hidden" name="commande" value="<?= $commande; ?>">
        <div class="form-group">
            <label for="exampleInputPassword1" class="form-label mt-4"> Mot de passe </label>
            <input type="password" class="form-control" name="mdp" id="exampleInputPassword1" placeholder="Mot de passe">
            <div>
                <a href="<?= BASE_PATH . 'user/inscription' ?>"> Pas encore inscrit ? Cliquez ici </a>
            </div>
        </div>

        <button type="submit" class="btn btn-primary"> Se connecter </button>

    </fieldset>

</form>

<?php include(VIEWS . '_partials/footer.php'); ?>