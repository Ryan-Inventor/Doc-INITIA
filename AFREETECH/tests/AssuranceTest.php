<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Assurance.php';
require_once __DIR__ . '/../models/Client.php';

class AssuranceTest {
    private $db;
    private $assurance;
    private $client;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->assurance = new Assurance($this->db);
        $this->client = new Client($this->db);
    }

    public function testCreateAssurance() {
        // Create a client first
        $this->client->nom = "TestAssurance";
        $this->client->prenom = "Client";
        $this->client->telephone = "000000000";
        $this->client->numero_cni = "TEST_ASSUR_CNI";
        $this->client->succursale_rattachee = "douala";
        $this->client->create();

        // Get Client ID
        $stmt = $this->db->prepare("SELECT id FROM clients WHERE numero_cni = 'TEST_ASSUR_CNI'");
        $stmt->execute();
        $client = $stmt->fetch(PDO::FETCH_ASSOC);

        // Clean up previous test runs
        $stmt = $this->db->prepare("DELETE FROM assurances WHERE numero_contrat = 'TEST-CONTRAT-001'");
        $stmt->execute();

        $this->assurance->client_id = $client['id'];
        $this->assurance->type_assurance = "auto";
        $this->assurance->numero_contrat = "TEST-CONTRAT-001";
        $this->assurance->montant_prime = 50000;
        $this->assurance->date_souscription = date('Y-m-d');
        $this->assurance->date_expiration = date('Y-m-d', strtotime('+1 year'));
        $this->assurance->statut = "active";
        $this->assurance->succursale_gestion = "douala";

        if (!$this->assurance->create()) {
            throw new Exception("Failed to create assurance");
        }
    }

    public function testReadAssurances() {
        $stmt = $this->assurance->read();
        $num = $stmt->rowCount();
        
        if ($num == 0) {
            throw new Exception("No assurances found after creation");
        }
    }
}
