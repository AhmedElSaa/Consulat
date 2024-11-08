<?php

class Model {
    private $db;
    private static $instance = null;

    /* Permet de connecter la base de données au site */ 
    private function __construct() {
        include "credentials.php";
        $this->db = new PDO($dsn, $login, $mdp);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /* Méthode permettant de récupérer un modèle car le constructeur est privé (Implémentation du Design Pattern Singleton) */
    public static function getModel() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /* Liste les nationnalités dans l'interface inscription */
    public function getNation() {
        $req = $this->db->prepare('SELECT * FROM nationalite');
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    /* Creer un utilisateur avec les infos de l'interface inscription */
    public function createUser($nom, $prenom, $email, $id_nation, $numPass, $dateExpPass, $dateNaissance, $password, $loterie, $role) {
        $req = $this->db->prepare('INSERT INTO utilisateurs (nom, prenom, email, id_nation, numPass, dateExpPass, dateNaissance, password, loterie, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $req->execute([$nom, $prenom, $email, $id_nation, $numPass, $dateExpPass, $dateNaissance, $password, $loterie, $role]);
        return $this->db->lastInsertId();
    }

    /* Cherche un utilisateur par son email */
    public function findUserByEmail($email) {
        $req = $this->db->prepare('SELECT * FROM utilisateurs WHERE email = ?');
        $req->execute([$email]);
        return $req->fetch(PDO::FETCH_ASSOC);
    }

    /* Récupere les infos d'un user pour la session */
    public function findUserById($id) {
        $req = $this->db->prepare('
            SELECT utilisateurs.*, nationalite.nation
            FROM utilisateurs
            LEFT JOIN nationalite ON utilisateurs.id_nation = nationalite.id_nation
            WHERE utilisateurs.id_utilisateur = ?
        ');
        $req->execute([$id]);
        return $req->fetch(PDO::FETCH_ASSOC);
    }

    /* Vérifie l'existence de l'email */ 
    public function emailExists($email) {
        $requete = $this->db->prepare('SELECT COUNT(*) FROM utilisateurs WHERE email = ?');
        $requete->execute([$email]);
        $count = $requete->fetchColumn();
        return $count > 0;
    }

    /* Vérifie l'existence du passeport */ 
    public function numPassExists($numPass) {
        $requete = $this->db->prepare('SELECT COUNT(*) FROM utilisateurs WHERE numPass = ?');
        $requete->execute([$numPass]);
        $count = $requete->fetchColumn();
        return $count > 0;
    }

    /* Liste les users dans l'interrface admin */
    public function listUsers() {
        $req = $this->db->prepare('
            SELECT utilisateurs.*, nationalite.nation
            FROM utilisateurs
            LEFT JOIN nationalite ON utilisateurs.id_nation = nationalite.id_nation
            ORDER BY utilisateurs.id_utilisateur
        ');
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    /* Supprime un users depuis l'interface admin */
    public function removeUsers($id) {
        $req = $this->db->prepare('DELETE FROM utilisateurs WHERE id_utilisateur = ?');
        $req->execute([$id]);
        return (bool) $req->rowCount();
    }

    /* Change l'id de la nation en nom */
    public function getNationIdByName($nationName) {
        $req = $this->db->prepare('SELECT id_nation FROM nationalite WHERE nation = ?');
        $req->execute([$nationName]);
        return $req->fetchColumn();
    }

    /* Récupere tous les users qui ne sont pas egyptiens pour le tirage au sort */
    public function countParticipants() {
        $egyptianNationId = $this->getNationIdByName('Égypte');

        $req = $this->db->prepare('SELECT COUNT(*) FROM utilisateurs WHERE loterie = 1 AND id_nation != ?');
        $req->execute([$egyptianNationId]);
        return (int) $req->fetchColumn();
    }

    /* Tire au hasard un user pour la lotterie */
    public function selectRandomWinner() {
        $egyptianNationId = $this->getNationIdByName('Égypte');

        $req = $this->db->prepare('SELECT * FROM utilisateurs WHERE loterie = 1 AND id_nation != ? ORDER BY RAND() LIMIT 1');
        $req->execute([$egyptianNationId]);
        return $req->fetch(PDO::FETCH_ASSOC);
    }

    /* Change la nationnalité si un user gagne a la lotterie */
    public function updateUserNationality($id_utilisateur, $id_nation) {
        $req = $this->db->prepare('UPDATE utilisateurs SET id_nation = ? WHERE id_utilisateur = ?');
        $req->execute([$id_nation, $id_utilisateur]);
    }

    /* Créer une requete de visa */
    public function createVisaRequest($id_utilisateur, $pays_residence, $adresse, $code_postal, $ville, $reference, $statut) {
        $req = $this->db->prepare('
            INSERT INTO visa (id_utilisateur, date, reference, statut, pays_residence, adresse, code_postal, ville)
            VALUES (?, NOW(), ?, ?, ?, ?, ?, ?)
        ');
        $req->execute([$id_utilisateur, $reference, $statut, $pays_residence, $adresse, $code_postal, $ville]);
        return $this->db->lastInsertId();
    }

    /* Liste les demandes de visa de l'user */
    public function getVisaRequestsByUser($id_utilisateur) {
        $req = $this->db->prepare('SELECT * FROM visa WHERE id_utilisateur = ? ORDER BY date DESC');
        $req->execute([$id_utilisateur]);
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    /* Recupere les nationnalité bannie */ 
    public function isNationalityBanned($id_nation) {
        $req = $this->db->prepare('SELECT COUNT(*) FROM banned_nationalities WHERE id_nation = ?');
        $req->execute([$id_nation]);
        return $req->fetchColumn() > 0;
    }

}
