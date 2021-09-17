<?php

class CategoriesController {

    public static function add() {
        if (isset($_GET['id'])) :
            $categorie = Categorie::find([
                'id_categorie' => $_GET['id']
            ]);
        endif;
        
        include(VIEWS . 'categories/add.php');
    }

    public static function save() {
        Categorie::create([
            'id_categorie' => $_POST['id'],
            'nom' => $_POST['nom'],
        ]);

        $_SESSION['messages']['success'][] = 'Catégorie ajoutée avec succés ';
        header('location:../categories/list');
        exit();
    }

    public static function list() {
        $categories = Categorie::findAll();
        include(VIEWS . 'categories/list.php');
    }

    public static function delete() {
        Categorie::delete([
            'id_categorie' => $_GET['id']
        ]);

        $_SESSION['messages']['success'][] = 'Catégorie supprimée avec succès';
        header('location:../categories/list');
        exit();
    }

}
