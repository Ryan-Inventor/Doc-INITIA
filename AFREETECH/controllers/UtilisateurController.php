<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Utilisateur.php';

class UtilisateurController {

    private $db;

    public function __construct() {
        // Démarrage sécurisé de la session (comme dans les autres contrôleurs)
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Vérifie que l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            redirect('login');
        }

        // Vérifie que l'utilisateur est administrateur pour accéder à la gestion des utilisateurs
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            // On peut rediriger vers le dashboard ou la page de login selon la politique choisie
            redirect('dashboard');
        }

        // Initialisation de la connexion à la base de données
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function index() {
        $utilisateurModel = new Utilisateur($this->db);
        $utilisateurs = $utilisateurModel->getAll();
        
        require __DIR__ . '/../views/utilisateurs/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nomComplet = $_POST['nom'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $role = $_POST['role'];
            $succursale = $_POST['succursale'];

            // On sépare éventuellement le nom complet en prénom + nom
            $parts = preg_split('/\s+/', trim($nomComplet), 2);
            $prenom = $parts[0] ?? '';
            $nom = $parts[1] ?? $parts[0] ?? '';

            $utilisateurModel = new Utilisateur($this->db);
            $utilisateurModel->nom = $nom;
            $utilisateurModel->prenom = $prenom;
            $utilisateurModel->email = $email;
            $utilisateurModel->mot_de_passe = password_hash($password, PASSWORD_DEFAULT);
            $utilisateurModel->role = $role;
            $utilisateurModel->succursale = $succursale;

            if ($utilisateurModel->create()) {
                redirect('utilisateurs');
            } else {
                $error = "Erreur lors de la création de l'utilisateur.";
                require __DIR__ . '/../views/utilisateurs/create.php';
            }
        } else {
            require __DIR__ . '/../views/utilisateurs/create.php';
        }
    }

    public function edit($id) {
        $utilisateurModel = new Utilisateur($this->db);
        $utilisateur = $utilisateurModel->getById($id);

        if (!$utilisateur) {
            redirect('utilisateurs');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'];
            $email = $_POST['email'];
            $role = $_POST['role'];
            $succursale = $_POST['succursale'];
            
            $password = !empty($_POST['password']) ? $_POST['password'] : null;

            if ($utilisateurModel->update($id, $nom, $email, $role, $succursale, $password)) {
                redirect('utilisateurs');
            } else {
                $error = "Erreur lors de la mise à jour.";
                require __DIR__ . '/../views/utilisateurs/edit.php';
            }
        } else {
            require __DIR__ . '/../views/utilisateurs/edit.php';
        }
    }

    public function delete($id) {
        $utilisateurModel = new Utilisateur($this->db);
        $utilisateurModel->delete($id);
        redirect('utilisateurs');
    }
}
