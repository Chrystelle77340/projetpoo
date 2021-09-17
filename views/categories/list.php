<?php include(VIEWS . '_partials/header.php'); ?>

<?php
if (!empty($_SESSION['membre']) && $_SESSION['membre']['role'] == 'ROLE_ADMIN') {
?>

    <a href="<? BASE_PATH . 'categories/add'; ?>" class="btn btn-secondary mb-2 mt-2"> Ajouter </a>

    <table class="table table-dark">
        <thead>
            <tr>
                <th scope="col"> # </th>
                <th scope="col"> Nom </th>
                <th scope="col"> Actions </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $categorie) : ?>
                <tr>
                    <th scope="row"> <?= $categorie['id_categorie'] ?> </th>
                    <td> <?= $categorie['nom'] ?> </td>
                    <td>
                        <a href="<?= BASE_PATH . 'categories/add?id=' . $categorie['id_categorie']; ?>" class="btn btn-light"> Modifier </a>
                        <a href="<?= BASE_PATH . 'categories/delete?id=' . $categorie['id_categorie']; ?>" class="btn btn-danger" onclick="return(confirm('Etes-vous sûr de vouloir supprimer ce produit ?'))"> Supprimer </a>
                    </td>
                </tr>
            <?php endforeach; ?>

        </tbody>
    </table>

<?php
} else {
    echo '<h1> Vous n\'avez pas les autorisations pour cette page, <a href="' . BASE_PATH .
        '" > Retour à l\'accueil </a> </h1>';
}
?>


<?php include(VIEWS . '_partials/footer.php'); ?>