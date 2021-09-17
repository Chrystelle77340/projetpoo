<?php

class Produit extends Db {

    public static function find($id) {
        $request = 'SELECT * FROM produit WHERE id_produit = :id_produit';
       // die(var_dump($request,$id));
        $response = self::getDb()->prepare($request);
       // die(var_dump($response));
        $response->execute($id);
        return $response->fetch(PDO::FETCH_ASSOC);
    }

    public static function findAll() {
        $request = 'SELECT * FROM produit';
        $response = self::getDb()->prepare($request);
        $response->execute();
        return $response->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create(array $data) {
        //die(var_dump($data));
        $request = "REPLACE INTO produit VALUES (:id_produit, :nom, :descriptif, :photo ,:prix, :stock, :categorie_id)";
        $response = self::getDb()->prepare($request);
        $response->execute($data);
        return self::getDb()->lastInsertId();
    }

    public static function delete($id) {
        $request = 'DELETE FROM produit WHERE id_produit = :id_produit';
        // die(var_dump($request,$id));
        $response = self::getDb()->prepare($request);
        // die(var_dump($response));
        return $response->execute($id);
    }
    
}
