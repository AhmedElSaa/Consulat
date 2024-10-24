<?php 

class Model {
    private $db;
    private static $instance = null;

    private function __construct()
    {
        include "credentials.php";
        $this->db = new PDO($dsn, $login, $mdp);
        $this->db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Méthode permettant de récupérer un modèle car le constructeur est privé (Implémentation du Design Pattern Singleton)
     */
    public static function getModel() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getNation() {
        $req = $this->db->prepare('SELECT * FROM nationalite');
        $req->execute();
        return $req->fetchAll();
    }

    public function createUser($nom, $prenom, $email, $id_nation, $numPass, $dateExpPass, $dateNaissance, $password, $loterie, $role ) {
        $req = $this->db->prepare('INSERT INTO utilisateurs (nom, prenom, email, id_nation, numPass, dateExpPass, dateNaissance, password, loterie, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $req->execute([$nom, $prenom, $email, $id_nation, $numPass, $dateExpPass, $dateNaissance, $password, $loterie, $role]);
        return $this->db->lastInsertId();
    }

    public function findUserByEmail($email) {
        $req = $this->db->prepare('SELECT * FROM utilisateurs WHERE email = ?');
        $req->execute([$email]);
        return $req->fetch(PDO::FETCH_ASSOC);
    }
    

    public function emailExists($email) {
        $requete = $this->db->prepare('SELECT COUNT(*) FROM utilisateurs WHERE email = ?');
        $requete->bindValue(1, $email, PDO::PARAM_STR);
        $requete->execute();
        $count = $requete->fetchColumn();
        return $count > 0;
    }

    public function numPassExists($numPass) {
        $requete = $this->db->prepare('SELECT COUNT(*) FROM utilisateurs WHERE numPass = ?');
        $requete->bindValue(1, $numPass, PDO::PARAM_STR);
        $requete->execute();
        $count = $requete->fetchColumn();
        return $count > 0;
    }

    /**
     * Méthode permettant de lister tous les inscrits avec une liaison des tables dans la bdd
     */
    public function listUsers() {
        $req = $this->db->prepare('SELECT *
        FROM utilisateurs
        ORDER BY id_utilisateur');
        $req->execute();
        return $req->fetchAll();
    }

    /**
     * Méthode permettant de supprimer quelqu'un de la liste
     * @param int $id
     */
    public function removeUsers($id) {
        $req = $this->db->prepare('DELETE FROM utilisateurs WHERE id_utilisateur = ?');
        $req->execute([$id]);
        return (bool) $req->rowCount();
    }

    public function findUserById($id) {
        $req = $this->db->prepare('SELECT * FROM utilisateurs WHERE id_utilisateur = ?');
        $req->execute([$id]);
        return $req->fetch(PDO::FETCH_ASSOC);
    }
    
    

}