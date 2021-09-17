<?php

class AppController {

    public static function index() {
        $produits = Produit::findAll();
        include(VIEWS . 'app/index.php');
    }

    public static function add() {
        $produit = Produit::find([
            'id_produit'=> $_POST['id']
        ]);

        $_SESSION['panier']['id'][] = $produit['id_produit'];
        $_SESSION['panier']['nom'][] = $produit['nom'];
        $_SESSION['panier']['photo'][] = $produit['photo'];
        $_SESSION['panier']['prix'][] = $produit['prix'];
        $_SESSION['panier']['quantite'][] = $_POST['quantite'];

        header('location:../');
        exit();
    }

    public static function list() {
        if (isset($_GET['action'])) {
            unset($_SESSION['panier']);
            header('location:../');
            exit();
        }
        include(VIEWS .'app/panier.php');
    }

    public static function inscription() {

        if (!empty($_POST)) {

            $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);

            $error = 0;
            if (!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $error++;
                $_SESSION['messages']['danger'][] = "L'email n'est pas valide";
            }

            if (!isset($_POST['cp']) || !preg_match('#^[0-9]{5}$#', $_POST['cp'])) {
                $error++;
                $_SESSION['messages']['danger'][] = "Le code postal n'est pas valide";
            }

            $user = Utilisateur::find(['email'=> $_POST['email']]);

            if ($user) {
                $error++;
                $_SESSION['messages']['danger'][] = "Un compte existe déjà à cette adresse mail";
            }

            if ($error !== 0) {
                header('location:../user/inscription');
                exit();
            }

            else {
                Utilisateur::create([
                    'id_utilisateur' => $_POST['id'],
                    'role' => 'ROLE_USER',
                    'nom' => $_POST['nom'],
                    'prenom' => $_POST['prenom'],
                    'email' => $_POST['email'],
                    'mdp' => $mdp,
                    'adresse' => $_POST['adresse'],
                    'cp' => $_POST['cp'],
                    'ville' => $_POST['ville'],
                    'tel' => $_POST['tel'],
                ]);

                $_SESSION['messages']['success'][] = 'Félicitations vous êtes inscrit ! Connectez vous à présent';
                header('location:../user/connexion');
                exit();
            }

        }

        include(VIEWS . 'app/inscription.php');

    }

    public static function connexion(){

        $commande = false;

        if (!empty($_GET['commande'])) {
            $commande = true;
        }

        if (!empty($_POST)) {
            $user = Utilisateur::find(['email' => $_POST['email']]);
            //die(var_dump($user));
            if (!empty($user)) {
                if (password_verify($_POST['mdp'], $user['mdp'])) {
                    $_SESSION['membre'] = $user;
                    $_SESSION['messages']['success'][] = "Bienvenue sur mon site " . $user['prenom'] . " !!";

                    if ($user['role'] == 'ROLE_USER' && $_POST['commande'] == false) {
                        header('location:../');
                        exit();
                    }
                    elseif ($user['role'] == 'ROLE_USER' && $_POST['commande'] == true) {
                        header('location:../panier/list');
                        exit();
                    }
                    else {
                        header('location:../produits/list');
                        exit();
                    }
                    
                } else {
                    $_SESSION['messages']['danger'][] = "Erreur sur le mot de passe";
                    header('location:../user/connexion');
                    exit();
                }
            }
            else {
                $_SESSION['messages']['danger'][] = "Aucun compte à cette adresse mail";
                header('location:../user/connexion');
                exit();
            }
        }

        if (!empty($_GET['action'])) {
            unset($_SESSION['membre']);
            $_SESSION['messages']['success'][] = "A bientôt !";
            header('location:../');
            exit();
        }
        
        include(VIEWS . 'app/connexion.php');
    }

}