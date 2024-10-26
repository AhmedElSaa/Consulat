<?php 

class Model {
    private $db;
    private static $instance = null;

    private function __construct()
    {
        include "credentials.php";
        $this->db = new PDO($dsn, $login, $mdp);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
        return $req->fetchAll(PDO::FETCH_ASSOC);
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
        $req = $this->db->prepare('
            SELECT utilisateurs.*, nationalite.nation
            FROM utilisateurs
            LEFT JOIN nationalite ON utilisateurs.id_nation = nationalite.id_nation
            ORDER BY utilisateurs.id_utilisateur
        ');
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
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

    /**
     * Compte le nombre de participants inscrits à la loterie.
     * @return int Le nombre de participants.
     */
    public function countParticipants() {
        $egyptianNationId = $this->getNationIdByName('Égypte');

        $req = $this->db->prepare('SELECT COUNT(*) FROM utilisateurs WHERE loterie = 1 AND id_nation != ?');
        $req->execute([$egyptianNationId]);
        return (int) $req->fetchColumn();
    }

    /**
     * Sélectionne un gagnant aléatoire parmi les participants.
     * @return array|false Les informations du gagnant ou false si aucun participant.
     */
    public function selectRandomWinner() {
        $egyptianNationId = $this->getNationIdByName('Égypte');

        $req = $this->db->prepare('SELECT * FROM utilisateurs WHERE loterie = 1 AND id_nation != ? ORDER BY RAND() LIMIT 1');
        $req->execute([$egyptianNationId]);
        return $req->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Met à jour la nationalité d'un utilisateur.
     * @param int $id_utilisateur L'ID de l'utilisateur.
     * @param int $id_nation Le nouvel ID de nationalité.
     */
    public function updateUserNationality($id_utilisateur, $id_nation) {
        $req = $this->db->prepare('UPDATE utilisateurs SET id_nation = ? WHERE id_utilisateur = ?');
        $req->execute([$id_nation, $id_utilisateur]);
    }

    /**
     * Récupère l'ID d'une nationalité par son nom.
     * @param string $nationName Le nom de la nationalité.
     * @return int|false L'ID de la nationalité ou false si non trouvé.
     */
    public function getNationIdByName($nationName) {
        $req = $this->db->prepare('SELECT id_nation FROM nationalite WHERE nation = ?');
        $req->execute([$nationName]);
        return $req->fetchColumn();
    }
}
