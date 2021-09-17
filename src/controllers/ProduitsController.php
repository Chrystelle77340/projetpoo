<?php

class ProduitsController {

    public static function add() {
        if (isset($_GET['id'])) {
           $id=intval($_GET['id'], 10);
            $produit = Produit::find($id);
           // die(var_dump($produit));
        }

        $categories = Categorie::findAll();
        include(VIEWS . 'produits/add.php');
    }

    public static function save() {

        // $_FILES contient toutes les informations des input type file
        // var_dump() permet de les afficher
        // die() permet de stopper le traitement en cours
        // die(var_dump($_POST, $_FILES));

        if (!empty($_FILES['photo']['name'])) {
            $photoname = $_FILES['photo']['name'];
            copy($_FILES['photo']['tmp_name'], PUBLIC_FOLDER . '/upload/' . $_FILES['photo']['name']);
        }

        if (!empty($_FILES['photo_update']['name'])) {
            $photoname = $_FILES['photo_update']['name'];
            copy($_FILES['photo_update']['tmp_name'], PUBLIC_FOLDER . '/upload/' . $_FILES['photo_update']['name']);
            unlink(PUBLIC_FOLDER . '/upload/' . $_POST['photo_actuelle']);

        }

        Produit::create([
            'id_produit'=> $_POST['id'],
            'nom'=> $_POST['nom'],
            'descriptif' => $_POST['descriptif'],
            'photo' => $photoname,
            'prix'=> $_POST['prix'],
            'stock'=> $_POST['stock'],
            'categorie_id'=> $_POST['categorie_id']
        ]);

        $_SESSION['messages']['success'][] = 'Produit ajouté avec succès';
        header('location:../');
        exit();

    }

    public static function list() {
        $categories = Categorie::findAll();
        $produits = Produit::findAll();
        include(VIEWS . 'produits/list.php');
    }

    public static function delete() {
        Produit::delete([
            'id_produit'=> $_GET['id']
        ]);

        $_SESSION['messages']['success'][] = 'Produit supprimé avec succès';
        header('location:../produits/list');
        exit();
    }

    public static function commande() {

        $total = 0;

        for ($i = 0 ; $i < count($_SESSION['panier']['id']) ; $i++) {
            $total += $_SESSION['panier']['prix'][$i] * $_SESSION['panier']['quantite'][$i];
        }

        $date = date_format(new DateTime('now'), 'Y-m-d');

        $response = Commande::create([
            'date'=> $date,
            'statut'=> 0,
            'montant'=> 150,
            'utilisateur_id'=> $_SESSION['membre']['id_utilisateur']
        ]);

        for ($i = 0; $i < count($_SESSION['panier']['id']); $i++) {
            Detail::create([
                'produit_id'=> $_SESSION['panier']['id'][$i],
                'commande_id'=> $response,
                'montant'=> $_SESSION['panier']['prix'][$i] * $_SESSION['panier']['quantite'][$i],
                'quantite'=> $_SESSION['panier']['quantite'][$i]
            ]);
        }

        unset($_SESSION['panier']);
        $_SESSION['messages']['success'][] = "Merci de votre confiance, votre commande a bien été prise en compte";
        header('location:../');
        exit();

        //die(var_dump($response));

    }

    public static function recap() {

        $commandes = Commande::findAll();
        //on initialise un tableau vide $details sur lequel on effectura des conditions dans recap.php
        $details = [];

        // ici on verifie la présence d'un parametre en GET (dans l'url), en l'occurence id, qui interviendra 
        // lorsque l'on clique sur afficher le detail dans récap.php. Cet id correspondant à l'id de la 
        // commande dont on souhaite afficher le détail
        if (!empty($_GET['id'])) {
            //si cet id est présent on appelle la méthode find présente dans le model detail.php qui permet 
            // de récupérer tout les achats (le détail) liés à cet id de commande (commande_id dans la table 
            // détail)
            $details = Detail::find(['commande_id' => $_GET['id']]);
        }
            
        // ici on vérifie la présence d'un parametre en GET 'action'
        if (!empty($_GET['action'])) {
            // si ce paramètre est présent on vide le tableau détail
            $details = [];
        }

        include(VIEWS.'produits/recap.php');
    }
    
}