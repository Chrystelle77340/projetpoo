<?php include(VIEWS . '_partials/header.php'); ?>

<?php
if (!empty($_SESSION['membre']) && $_SESSION['membre']['role'] == 'ROLE_ADMIN') {
?>

    <?php //var_dump($details);
    ?>

    <!--  on boucle ici sur toutes nos commandes présentes en BDD, pour chaques lignes de commande on créé un nouveau tableau
  qui lui même contiendra le détail de la commande si on demande son affichage -->
    <?php foreach ($commandes as $commande) : ?>
        <table class="table table-dark mb-1">
            <thead>
                <tr>
                    <?php $user = Utilisateur::findBy(['id_utilisateur' => $commande['utilisateur_id']]); ?>
                    <th class="text-center" colspan="6"> Commande passée par : <?= strtoupper($user['prenom']) .
                                                                                    ' ' . strtoupper($user['nom']) ?> </th>
                </tr>
                <tr>
                    <th scope="col"> # </th>
                    <th scope="col"> Date </th>
                    <th scope="col"> Montant </th>
                    <th scope="col"> Statut </th>
                    <th scope="col"> Détail </th>
                </tr>

            </thead>
            <tbody>
                <tr>
                    <th scope="row"><?= $commande['id_commande'] ?></th>
                    <td><?= date('d-m-Y', strtotime($commande['date'])) ?></td>
                    <td><?= $commande['montant'] ?> €</td>
                    <td><?= $commande['statut'] ?></td>

                    <!--  ici on pose la condition d'affichage de notre boutton 'afficher le détail' qui apparait uniquement si le tableau $details n'est pas vide (si on a pas effectuer la requete dans detail.php find() qui nous retourne tout les achats en liens avec cet id de commande )  -->
                    <?php if (empty($details)) : ?>
                        <td>
                            <a href="<?= BASE_PATH . 'produits/recap?id=' . $commande['id_commande'] ?>" class="btn btn-light">Afficher le détail</a>

                        </td>
                        <!--  sinon, si $details est rempli, ce qui signifie que l'on a cliqué sur le bouton afficher le détail et que l'id de commande a été transmit en GET et que l'on a ainsi récupéré tout nos achats liés à cet id de commande on modifie le bouton et proposons de cacher le détail de la commande avec un parametre en GET 'action=vider' qui réaffecte à $details un tableau vide dans la méthode recap() -->
                        <?php else :
                        // ici on s'assure que l'entrée 0 de notre tableau $details ai bien pour commande_id la même valeur que l'id de la commande
                        if ($details[0]['commande_id'] == $commande['id_commande']) :    ?>

                            <td>
                                <a href="<?= BASE_PATH . 'produits/recap?action=vider' ?>" class="btn btn-light">Cacher le détail</a>

                            </td>
                        <?php
                        // si l'id de la ligne du tableau commande ne correspond pas au commande_id de $details c'est que le détail ne correspond pas à cette commande et donc on maintiens la possibiliter d'afficher le détail pour cette commande précisement
                        else : ?>
                            <td>
                                <a href="<?= BASE_PATH . 'produits/recap?id=' . $commande['id_commande'] ?>" class="btn btn-light">Afficher le détail</a>

                            </td>
                    <?php endif;
                    endif; ?>
                </tr>
            </tbody>
        </table>
      <?php //  var_dump($details); ?>
        <!-- ici on génére le tableau d'affichage du détail de nos produits en liens avec la commande
  on pose la condition si notre tableau $details n'est pas vide et à nouveau si l'id de la ligne de commande du tableau est le même que le commande_id de nos achats présent dans $details -->
        <?php  if (!empty($details) && $details[0]['commande_id'] == $commande['id_commande']) : ?>
            <table class="table table-light mt-0">
                <thead>
                    <tr>
                        <th scope="col"> Produit photo </th>
                        <th scope="col"> Produit nom </th>
                        <th scope="col"> Montant </th>
                        <th scope="col"> Quantité</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($details as $detail) :
                        // dans la table détail, nous avons access  à la propriété produit_id ainsi pour obtenir le détail de notre produit on appel la méthode find() du model produit.php à laquelle on transmet le produit_id de notre ligne de détail en paramètre et accédons directement à la propriété souhaité du produit
                        $produit = Produit::find(['id_produit' => $detail['produit_id']]);
                    ?>
                        <tr>

                            <td><img src="<?= '../../upload/' . $produit['photo'] ?>" width="50" height="50" alt=""></td>
                            <td><?= $produit['nom']  ?></td>
                            <td><?= $detail['montant'] ?> €</td>
                            <td><?= $detail['quantite'] ?></td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
    <?php endif;
    endforeach; ?>

<?php
} else {
    echo '<h1> Vous n\'avez pas les autorisations pour cette page, <a href="' . BASE_PATH .
        '" > Retour à l\'accueil </a> </h1>';
}
?>


<?php include(VIEWS . '_partials/footer.php'); ?>