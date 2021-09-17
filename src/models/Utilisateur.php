<?php

class Utilisateur extends Db {

    public static function create(array $data) {
        $request = "REPLACE INTO utilisateur VALUES (:id_utilisateur, :role, :nom, :prenom, :email ,:mdp, :adresse, :cp, :ville, :tel)";
        $response = self::getDb()->prepare($request);
        $response->execute($data);
        return self::getDb()->lastInsertId();
    }

    public static function find($email) {
        $request = 'SELECT * FROM utilisateur WHERE email = :email';
        $response = self::getDb()->prepare($request);
        $response->execute($email);
        return $response->fetch(PDO::FETCH_ASSOC);
    }

    public static function findBy($id) {
        $request = 'SELECT * FROM utilisateur WHERE id_utilisateur = :id_utilisateur';
        $response = self::getDb()->prepare($request);
        $response->execute($id);
        return $response->fetch(PDO::FETCH_ASSOC);
    }

}