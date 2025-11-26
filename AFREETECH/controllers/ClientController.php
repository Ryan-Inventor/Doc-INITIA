<?php
require_once __DIR__ . '/../models/Client.php';
require_once __DIR__ . '/../config/database.php';

/**
 * ClientController
 * 
 * Handles all operations related to Client management.
 */
class ClientController {
    private $db;
    private $client;

    /**
     * Constructor
     * Initializes database connection and Client model.
     * Checks for active session.
     */
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->client = new Client($this->db);
        
        // Ensure user is logged in
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            redirect('login');
        }
    }

    /**
     * Display list of clients
     * Filters by branch if user is not admin.
     */
    public function index() {
        $succursale = $_SESSION['user_succursale'];
        $stmt = $this->client->read($succursale);
        $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require __DIR__ . '/../views/clients/index.php';
    }

    /**
     * Show client details
     * @param int $id
     */
    public function show($id) {
        $this->client->id = $id;
        $this->client->readOne();
        require __DIR__ . '/../views/clients/show.php';
    }

    /**
     * Create a new client
     * Handles both GET (form display) and POST (submission).
     */
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->client->nom = $_POST['nom'];
            $this->client->prenom = $_POST['prenom'];
            $this->client->telephone = $_POST['telephone'];
            $this->client->email = $_POST['email'];
            $this->client->adresse = $_POST['adresse'];
            $this->client->ville = $_POST['ville'];
            $this->client->date_naissance = $_POST['date_naissance'];
            $this->client->numero_cni = $_POST['numero_cni'];
            $this->client->succursale_rattachee = $_POST['succursale_rattachee'];

            if ($this->client->create()) {
                redirect('clients');
            } else {
                $error = "Erreur lors de la création du client.";
            }
        }
        require __DIR__ . '/../views/clients/create.php';
    }

    /**
     * Edit an existing client
     * @param int $id Client ID
     */
    public function edit($id) {
        $this->client->id = $id;
        $this->client->readOne();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->client->nom = $_POST['nom'];
            $this->client->prenom = $_POST['prenom'];
            $this->client->telephone = $_POST['telephone'];
            $this->client->email = $_POST['email'];
            $this->client->adresse = $_POST['adresse'];
            $this->client->ville = $_POST['ville'];
            $this->client->date_naissance = $_POST['date_naissance'];
            $this->client->numero_cni = $_POST['numero_cni'];
            $this->client->succursale_rattachee = $_POST['succursale_rattachee'];

            if ($this->client->update()) {
                redirect('clients');
            } else {
                $error = "Erreur lors de la modification du client.";
            }
        }
        require __DIR__ . '/../views/clients/edit.php';
    }

    /**
     * Delete a client
     * @param int $id Client ID
     */
    public function delete($id) {
        $this->client->id = $id;
        if ($this->client->delete()) {
            redirect('clients');
        } else {
            echo "Erreur lors de la suppression.";
        }
    }
}
