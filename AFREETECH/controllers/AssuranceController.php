<?php
require_once __DIR__ . '/../models/Assurance.php';
require_once __DIR__ . '/../models/Client.php';
require_once __DIR__ . '/../config/database.php';

/**
 * AssuranceController
 * 
 * Handles all operations related to Assurance contracts management.
 */
class AssuranceController {
    private $db;
    private $assurance;
    private $client;

    /**
     * Constructor
     * Initializes database connection and models.
     * Checks for active session.
     */
    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->assurance = new Assurance($this->db);
        $this->client = new Client($this->db);
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            redirect('login');
        }
    }

    /**
     * Display list of assurances
     * Filters by branch if user is not admin.
     */
    public function index() {
        $succursale = $_SESSION['user_succursale'];
        $stmt = $this->assurance->read($succursale);
        $assurances = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require __DIR__ . '/../views/assurances/index.php';
    }

    /**
     * Show assurance details
     * @param int $id
     */
    public function show($id) {
        $this->assurance->id = $id;
        $this->assurance->readOne();
        
        // Get client details for display
        $this->client->id = $this->assurance->client_id;
        $this->client->readOne();
        
        require __DIR__ . '/../views/assurances/show.php';
    }

    /**
     * Create a new assurance contract
     * Handles both GET (form display) and POST (submission).
     */
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->assurance->client_id = $_POST['client_id'];
            $this->assurance->type_assurance = $_POST['type_assurance'];
            $this->assurance->numero_contrat = $_POST['numero_contrat'];
            $this->assurance->montant_prime = $_POST['montant_prime'];
            $this->assurance->date_souscription = $_POST['date_souscription'];
            $this->assurance->date_expiration = $_POST['date_expiration'];
            $this->assurance->statut = 'active';
            $this->assurance->succursale_gestion = $_POST['succursale_gestion'];

            if ($this->assurance->create()) {
                redirect('assurances');
            } else {
                $error = "Erreur lors de la création du contrat.";
            }
        }
        
        // Get clients for dropdown
        $succursale = $_SESSION['user_succursale'];
        $stmt = $this->client->read($succursale);
        $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        require __DIR__ . '/../views/assurances/create.php';
    }

    /**
     * Edit an existing assurance contract
     * @param int $id Assurance ID
     */
    public function edit($id) {
        $this->assurance->id = $id;
        $this->assurance->readOne();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->assurance->type_assurance = $_POST['type_assurance'];
            $this->assurance->montant_prime = $_POST['montant_prime'];
            $this->assurance->date_souscription = $_POST['date_souscription'];
            $this->assurance->date_expiration = $_POST['date_expiration'];
            $this->assurance->statut = $_POST['statut'];
            $this->assurance->succursale_gestion = $_POST['succursale_gestion'];

            if ($this->assurance->update()) {
                redirect('assurances');
            } else {
                $error = "Erreur lors de la modification du contrat.";
            }
        }
        require __DIR__ . '/../views/assurances/edit.php';
    }

    /**
     * Delete an assurance contract
     * @param int $id Assurance ID
     */
    public function delete($id) {
        $this->assurance->id = $id;
        if ($this->assurance->delete()) {
            redirect('assurances');
        } else {
            echo "Erreur lors de la suppression.";
        }
    }
}
