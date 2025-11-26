<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Utilisateur.php';

class UtilisateurTest {
    private $db;
    private $utilisateur;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->utilisateur = new Utilisateur($this->db);
    }

    public function testCreateUser() {
        // Clean up first
        $stmt = $this->db->prepare("DELETE FROM utilisateurs WHERE email = 'test@example.com'");
        $stmt->execute();

        $this->utilisateur->nom = "Test";
        $this->utilisateur->prenom = "User";
        $this->utilisateur->email = "test@example.com";
        $this->utilisateur->mot_de_passe = password_hash("password123", PASSWORD_BCRYPT);
        $this->utilisateur->role = "gestionnaire";
        $this->utilisateur->succursale = "douala";

        if (!$this->utilisateur->create()) {
            throw new Exception("Failed to create user");
        }
    }

    public function testLoginSuccess() {
        if (!$this->utilisateur->login("test@example.com", "password123")) {
            throw new Exception("Login failed with correct credentials");
        }
    }

    public function testLoginFailure() {
        if ($this->utilisateur->login("test@example.com", "wrongpassword")) {
            throw new Exception("Login succeeded with wrong credentials");
        }
    }
}
