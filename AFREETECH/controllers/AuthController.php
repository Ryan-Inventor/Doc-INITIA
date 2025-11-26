<?php
require_once __DIR__ . '/../models/Utilisateur.php';
require_once __DIR__ . '/../config/database.php';

class AuthController {
    private $db;
    private $user;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new Utilisateur($this->db);
    }

    public function login() {
        $error = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if ($this->user->login($email, $password)) {
                session_start();
                $_SESSION['user_id'] = $this->user->id;
                $_SESSION['user_name'] = $this->user->prenom . ' ' . $this->user->nom;
                $_SESSION['user_role'] = $this->user->role;
                $_SESSION['user_succursale'] = $this->user->succursale;

                redirect('dashboard');
            } else {
                $error = "Email ou mot de passe incorrect.";
            }
        }

        require __DIR__ . '/../views/auth/login.php';
    }

    public function logout() {
        session_start();
        session_destroy();
        redirect('login');
    }
}
