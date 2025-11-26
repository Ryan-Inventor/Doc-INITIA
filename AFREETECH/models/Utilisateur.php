<?php
require_once __DIR__ . '/../config/database.php';

class Utilisateur {
    private $conn;
    private $table_name = "utilisateurs";

    public $id;
    public $nom;
    public $prenom;
    public $email;
    public $mot_de_passe;
    public $role;
    public $succursale;
    public $date_creation;

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Create a new user
     * 
     * @return bool
     */
    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                SET
                    nom = :nom,
                    prenom = :prenom,
                    email = :email,
                    mot_de_passe = :mot_de_passe,
                    role = :role,
                    succursale = :succursale";

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->prenom = htmlspecialchars(strip_tags($this->prenom));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->role = htmlspecialchars(strip_tags($this->role));
        $this->succursale = htmlspecialchars(strip_tags($this->succursale));

        // Bind
        $stmt->bindParam(":nom", $this->nom);
        $stmt->bindParam(":prenom", $this->prenom);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":mot_de_passe", $this->mot_de_passe);
        $stmt->bindParam(":role", $this->role);
        $stmt->bindParam(":succursale", $this->succursale);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    /**
     * Check if email exists
     * 
     * @param string $email
     * @return bool
     */
    public function emailExists($email) {
        $query = "SELECT id, nom, prenom, mot_de_passe, role, succursale
                FROM " . $this->table_name . "
                WHERE email = ?
                LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $email);
        $stmt->execute();

        $num = $stmt->rowCount();

        if ($num > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            $this->nom = $row['nom'];
            $this->prenom = $row['prenom'];
            $this->mot_de_passe = $row['mot_de_passe'];
            $this->role = $row['role'];
            $this->succursale = $row['succursale'];
            $this->email = $email;
            return true;
        }
        return false;
    }

    /**
     * Login user
     * 
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function login($email, $password) {
        if ($this->emailExists($email)) {
            if (password_verify($password, $this->mot_de_passe)) {
                return true;
            }
        }
        return false;
    }

    public function getAll() {
        // On retourne également un champ calculé nom_complet pour la vue
        $sql = "SELECT 
                    id,
                    nom,
                    prenom,
                    email,
                    mot_de_passe,
                    role,
                    succursale,
                    date_creation,
                    CONCAT(prenom, ' ', nom) AS nom_complet
                FROM " . $this->table_name . " 
                ORDER BY date_creation DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM utilisateurs WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $nom, $email, $role, $succursale, $password = null) {
        if ($password) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->conn->prepare("UPDATE utilisateurs SET nom = ?, email = ?, mot_de_passe = ?, role = ?, succursale = ? WHERE id = ?");
            return $stmt->execute([$nom, $email, $hashed_password, $role, $succursale, $id]);
        } else {
            $stmt = $this->conn->prepare("UPDATE utilisateurs SET nom = ?, email = ?, role = ?, succursale = ? WHERE id = ?");
            return $stmt->execute([$nom, $email, $role, $succursale, $id]);
        }
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM utilisateurs WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
