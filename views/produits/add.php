<?php include(VIEWS . '_partials/header.php'); ?>

<?php
    if (!empty($_SESSION['membre']) && $_SESSION['membre']['role'] == 'ROLE_ADMIN') {
?>

<form action="<?= BASE_PATH . 'produits/save' ?>" method="post" enctype="multipart/form-data">

    <fieldset>

        <input type="hidden" name="id" value="<?php echo $produit['id_produit'] ?? ''; ?>">

        <div class="form-group">
            <label for="exampleInputPassword1" class="form-label mt-2">Nom</label>
            <input name='nom' type="text" value="<?php echo $produit['nom'] ?? ''; ?>" class="form-control" id="exampleInputPassword1" placeholder="Nom">
        </div>

        <div class="form-group">
            <label for="exampleInputPassword1" class="form-label mt-2">Prix</label>
            <input name='prix' type="text" value="<?php echo $produit['prix'] ?? ''; ?>" class="form-control" id="exampleInputPassword1" placeholder="Prix">
        </div>

        <div class="form-group">
            <label for="exampleInputPassword1" class="form-label mt-2">Stock</label>
            <input name='stock' type="number" value="<?php echo $produit['stock'] ?? ''; ?>" class="form-control" id="stock" placeholder="Stock">
        </div>

        <div class="form-group">
            <label for="exampleSelect1" class="form-label mt-2">Catégories</label>
            <select name="categorie_id" class="form-select" id="exampleSelect1">
                <?php
                foreach ($categories as $categorie) {
                ?>
                    <option <?php if (isset($produit['categorie_id']) && $categorie['id_categorie'] == $produit['categorie_id']) {
                                echo 'selected';
                            } ?> value="<?= $categorie['id_categorie']; ?>">
                        <?= $categorie['nom']; ?>> </option>
                <?php
                }
                ?>

            </select>
        </div>

        <div class=" form-group">
            <label for="exampleTextarea" class="form-label mt-2"> Descriptif </label>
            <textarea name='descriptif' class="form-control" id="exampleTextarea" rows="3"> </textarea>
        </div>
        <?php
        if (isset($produit) && !empty($produit['photo'])) { ?>
            <div class="form-group">
                <label for="formFile" class="form-label mt-2"> Photo </label>
                <input type="hidden" name="photo_actuelle" value="<?= $produit['photo'] ?>">
                <input name='photo_update' onchange="loadFile(event)" class="form-control" type="file" id="formFile">
                <img src="<?= '../../upload/' . $produit['photo'] ?>" width="70" class="mt-3" height="70" alt="">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <label for=""> Photo après changement </label>
                        <img id="image" width="90" class="mt-3">
                    </div>
                </div>
            <?php
        } else {
            ?>
                <div class="form-group">
                    <label for="formFile" class="form-label mt-2"> Photo </label>
                    <input name='photo' onchange="loadFile(event)" class="form-control" type="file" id="formFile">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <label for=""> Photo avant changement </label> <br>
                            <img id="image" width="90" class="mt-3">
                        </div>
                    </div>
                <?php
            }
                ?>
                <button type="submit" class="btn btn-primary mt-2 mb-5"> Envoyer </button>

    </fieldset>

</form>

<script>
    let loadFile = function(event) {
        let image = document.getElementById('image');
        image.src = URL.createObjectURL(event.target.files[0]);
    }
</script>

<?php
    }
    else {
        echo '<h1> Vous n\'avez pas les autorisations pour cette page, <a href="' . BASE_PATH . 
        '" > Retour à l\'accueil </a> </h1>';
    }
?>


<?php include(VIEWS . '_partials/footer.php'); ?>