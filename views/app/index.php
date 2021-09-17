<?php include(VIEWS . '_partials/header.php'); ?>

<div class="row>">

    <?php
    foreach ($produits as $produit) {
    ?>

        <div class="col md-4">
            <div class="card border-secondary mb-3" style="max-width: 20rem;">
                <div class="card-header"> <?= $produit['nom'] ?> </div>
                <div class="card-body">
                    <img src="<?= PICTURES . $produit['photo'] ?>" alt="" width="150">
                    <h4 class="card-title"> <?= $produit['prix'] ?> </h4>
                    <p class="card-text"> <?= $produit['descriptif'] ?> </p>
                </div>
                <div class="card-footer">
                    <form action="<?= BASE_PATH . 'panier/add' ?>" method="post">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="hidden" name="id" value="<?= $produit['id_produit'] ?>">
                                    <select name="quantite" class="form-select" id="exampleSelect1">
                                        <?php
                                        for ($i = 1; $i <= $produit['stock']; $i++) {
                                        ?>
                                </div>
                                <option value="<?= $i ?>"> <?= $i ?> </option>
                            <?php
                                        }
                            ?>
                            </select>
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-secondary btn-sm" type="submit"> Ajouter au panier </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <?php
        }
    ?>

</div>

<?php include(VIEWS . '_partials/footer.php'); ?>