<?php
require_once __DIR__ . '/../config/database.php';

class Assurance {
    private $conn;
    private $table_name = "assurances";

    public $id;
    public $client_id;
    public $type_assurance;
    public $numero_contrat;
    public $montant_prime;
    public $date_souscription;
    public $date_expiration;
    public $statut;
    public $succursale_gestion;

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Create new assurance
     * @return bool
     */
    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                SET
                    client_id = :client_id,
                    type_assurance = :type_assurance,
                    numero_contrat = :numero_contrat,
                    montant_prime = :montant_prime,
                    date_souscription = :date_souscription,
                    date_expiration = :date_expiration,
                    statut = :statut,
                    succursale_gestion = :succursale_gestion";

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->client_id = htmlspecialchars(strip_tags($this->client_id));
        $this->type_assurance = htmlspecialchars(strip_tags($this->type_assurance));
        $this->numero_contrat = htmlspecialchars(strip_tags($this->numero_contrat));
        $this->montant_prime = htmlspecialchars(strip_tags($this->montant_prime));
        $this->date_souscription = htmlspecialchars(strip_tags($this->date_souscription));
        $this->date_expiration = htmlspecialchars(strip_tags($this->date_expiration));
        $this->statut = htmlspecialchars(strip_tags($this->statut));
        $this->succursale_gestion = htmlspecialchars(strip_tags($this->succursale_gestion));

        // Bind
        $stmt->bindParam(":client_id", $this->client_id);
        $stmt->bindParam(":type_assurance", $this->type_assurance);
        $stmt->bindParam(":numero_contrat", $this->numero_contrat);
        $stmt->bindParam(":montant_prime", $this->montant_prime);
        $stmt->bindParam(":date_souscription", $this->date_souscription);
        $stmt->bindParam(":date_expiration", $this->date_expiration);
        $stmt->bindParam(":statut", $this->statut);
        $stmt->bindParam(":succursale_gestion", $this->succursale_gestion);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    /**
     * Read all assurances (with optional filters)
     * @param string $succursale
     * @return PDOStatement
     */
    public function read($succursale = null) {
        $query = "SELECT a.*, c.nom as client_nom, c.prenom as client_prenom 
                  FROM " . $this->table_name . " a
                  LEFT JOIN clients c ON a.client_id = c.id";
        
        if ($succursale && $succursale !== 'direction') {
            $query .= " WHERE a.succursale_gestion = :succursale";
        }
        
        $query .= " ORDER BY a.date_souscription DESC";

        $stmt = $this->conn->prepare($query);
        
        if ($succursale && $succursale !== 'direction') {
            $stmt->bindParam(":succursale", $succursale);
        }

        $stmt->execute();
        return $stmt;
    }

    /**
     * Get single assurance details
     */
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->client_id = $row['client_id'];
            $this->type_assurance = $row['type_assurance'];
            $this->numero_contrat = $row['numero_contrat'];
            $this->montant_prime = $row['montant_prime'];
            $this->date_souscription = $row['date_souscription'];
            $this->date_expiration = $row['date_expiration'];
            $this->statut = $row['statut'];
            $this->succursale_gestion = $row['succursale_gestion'];
        }
    }

    /**
     * Update assurance
     * @return bool
     */
    public function update() {
        $query = "UPDATE " . $this->table_name . "
                SET
                    type_assurance = :type_assurance,
                    montant_prime = :montant_prime,
                    date_souscription = :date_souscription,
                    date_expiration = :date_expiration,
                    statut = :statut,
                    succursale_gestion = :succursale_gestion
                WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->type_assurance = htmlspecialchars(strip_tags($this->type_assurance));
        $this->montant_prime = htmlspecialchars(strip_tags($this->montant_prime));
        $this->date_souscription = htmlspecialchars(strip_tags($this->date_souscription));
        $this->date_expiration = htmlspecialchars(strip_tags($this->date_expiration));
        $this->statut = htmlspecialchars(strip_tags($this->statut));
        $this->succursale_gestion = htmlspecialchars(strip_tags($this->succursale_gestion));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind
        $stmt->bindParam(":type_assurance", $this->type_assurance);
        $stmt->bindParam(":montant_prime", $this->montant_prime);
        $stmt->bindParam(":date_souscription", $this->date_souscription);
        $stmt->bindParam(":date_expiration", $this->date_expiration);
        $stmt->bindParam(":statut", $this->statut);
        $stmt->bindParam(":succursale_gestion", $this->succursale_gestion);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    /**
     * Delete assurance
     * @return bool
     */
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
