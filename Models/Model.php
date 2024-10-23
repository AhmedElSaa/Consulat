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

    public function createUser($nom, $prenom, $email, $nationalite, $numPass, $dateExpPass, $dateNaissance, $password, $loterie, $role ) {
        $password = 'aq1'.sha1($password.'1524').'25';
        $req = $this->db->prepare('INSERT INTO utilisateurs (nom, prenom, email, nationalite, numPass, dateExpPass, dateNaissance, password, loterie, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $req->execute([$nom, $prenom, $email, $nationalite, $numPass, $dateExpPass, $dateNaissance, $password, $loterie, $role]);
        return $this->db->lastInsertId();
    }

    public function findUserByEmail($email) {
        $req = $this->db->prepare('SELECT * FROM utilisateurs WHERE email = ?');
        $req->execute([$email]);
        return $req->fetch();
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

    public function getUserAndRole($email) {
        $req = $this->db->prepare("
            SELECT utilisateur.*, 
                    CASE WHEN u.id_utilisateur IS NOT NULL THEN 'user'
                         WHEN a.id_utilisateur IS NOT NULL THEN 'admin'
                         ELSE 'inconnu' 
                    END as role
            FROM utilisateur
            LEFT JOIN user u ON utilisateur.id_utilisateur = u.id_utilisateur
            LEFT JOIN admin a ON utilisateur.id_utilisateur = a.id_utilisateur
            WHERE utilisateur.mail = ?"
        );
        $req->execute([$email]);
        return $req->fetch(PDO::FETCH_ASSOC);
    }

}