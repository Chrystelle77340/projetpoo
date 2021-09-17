<?php include(VIEWS . '_partials/header.php'); ?>

<?php
if (!empty($_SESSION['membre']) && $_SESSION['membre']['role'] == 'ROLE_ADMIN') {
?>

    <a href="<?= BASE_PATH . 'produits/add'; ?>" class="btn btn-secondary mb-2 mt-2"> Ajouter </a>

    <table class="table">
        <thead>
            <tr>
                <th scope="col"> # </th>
                <th scope="col"> Nom </th>
                <th scope="col"> Descriptif </th>
                <th scope="col"> Catégorie </th>
                <th scope="col"> Prix </th>
                <th scope="col"> Stock </th>
                <th scope="col"> Photo </th>
                <th scope="col"> Actions </th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($produits as $produit) {
            ?>
                <tr>
                    <th scope="row"> <?= $produit['id_produit'] ?> </th>
                    <td> <?= $produit['nom'] ?> </td>
                    <td> <?= $produit['descriptif'] ?> </td>
                    <?php
                    foreach ($categories as $categorie) {
                        if ($categorie['id_categorie'] == $produit['categorie_id']) {
                    ?>
                            <td> <?= $categorie['nom'] ?> </td>
                        <?php
                        }
                        ?>
                    <?php
                    }
                    ?>
                    <td> <?= $produit['prix'] ?> </td>
                    <td> <?= $produit['stock'] ?> </td>
                    <td> <img src="<?= '../../upload/' . $produit['photo'] ?>" width="40" height="40" alt=""> </td>
                    <td>
                        <a href="<?= BASE_PATH . 'produits/add?id=' . $produit['id_produit']; ?>" class="btn btn-light"> Modifier </a>
                        <a href="<?= BASE_PATH . 'produits/delete?id=' . $produit['id_produit']; ?>" class="btn btn-danger" onclick="return(confirm('Etes-vous sûr de vouloir supprimer ce produit ?'))"> Supprimer </a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>

<?php
} else {
    echo '<h1> Vous n\'avez pas les autorisations pour cette page, <a href="' . BASE_PATH .
        '" > Retour à l\'accueil </a> </h1>';
}
?>


<?php include(VIEWS . '_partials/footer.php'); ?>