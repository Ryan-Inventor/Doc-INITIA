<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Client.php';

class ClientTest {
    private $db;
    private $client;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->client = new Client($this->db);
    }

    public function testCreateClient() {
        // Clean up first
        $stmt = $this->db->prepare("DELETE FROM clients WHERE numero_cni = '123456789'");
        $stmt->execute();

        $this->client->nom = "Doe";
        $this->client->prenom = "John";
        $this->client->telephone = "699999999";
        $this->client->email = "john.doe@example.com";
        $this->client->adresse = "Akwa";
        $this->client->ville = "Douala";
        $this->client->date_naissance = "1990-01-01";
        $this->client->numero_cni = "123456789";
        $this->client->succursale_rattachee = "douala";

        if (!$this->client->create()) {
            throw new Exception("Failed to create client");
        }
    }

    public function testReadClients() {
        $stmt = $this->client->read();
        $num = $stmt->rowCount();
        
        if ($num == 0) {
            throw new Exception("No clients found after creation");
        }
    }

    public function testUpdateClient() {
        // First get the ID of the client we just created
        $stmt = $this->db->prepare("SELECT id FROM clients WHERE numero_cni = '123456789'");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $id = $row['id'];

        $this->client->id = $id;
        $this->client->nom = "Doe Updated";
        $this->client->prenom = "John";
        $this->client->telephone = "699999999";
        $this->client->email = "john.doe@example.com";
        $this->client->adresse = "Akwa";
        $this->client->ville = "Douala";
        $this->client->date_naissance = "1990-01-01";
        $this->client->numero_cni = "123456789";
        $this->client->succursale_rattachee = "douala";

        if (!$this->client->update()) {
            throw new Exception("Failed to update client");
        }
    }
}
