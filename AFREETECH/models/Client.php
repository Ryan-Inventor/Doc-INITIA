<?php
require_once __DIR__ . '/../config/database.php';

class Client {
    private $conn;
    private $table_name = "clients";

    public $id;
    public $nom;
    public $prenom;
    public $telephone;
    public $email;
    public $adresse;
    public $ville;
    public $date_naissance;
    public $numero_cni;
    public $succursale_rattachee;
    public $date_inscription;

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Create a new client
     * @return bool
     */
    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                SET
                    nom = :nom,
                    prenom = :prenom,
                    telephone = :telephone,
                    email = :email,
                    adresse = :adresse,
                    ville = :ville,
                    date_naissance = :date_naissance,
                    numero_cni = :numero_cni,
                    succursale_rattachee = :succursale_rattachee";

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->prenom = htmlspecialchars(strip_tags($this->prenom));
        $this->telephone = htmlspecialchars(strip_tags($this->telephone));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->adresse = htmlspecialchars(strip_tags($this->adresse));
        $this->ville = htmlspecialchars(strip_tags($this->ville));
        $this->date_naissance = htmlspecialchars(strip_tags($this->date_naissance));
        $this->numero_cni = htmlspecialchars(strip_tags($this->numero_cni));
        $this->succursale_rattachee = htmlspecialchars(strip_tags($this->succursale_rattachee));

        // Bind
        $stmt->bindParam(":nom", $this->nom);
        $stmt->bindParam(":prenom", $this->prenom);
        $stmt->bindParam(":telephone", $this->telephone);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":adresse", $this->adresse);
        $stmt->bindParam(":ville", $this->ville);
        $stmt->bindParam(":date_naissance", $this->date_naissance);
        $stmt->bindParam(":numero_cni", $this->numero_cni);
        $stmt->bindParam(":succursale_rattachee", $this->succursale_rattachee);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    /**
     * Read all clients (with optional filters)
     * @param string $succursale (optional)
     * @return PDOStatement
     */
    public function read($succursale = null) {
        $query = "SELECT * FROM " . $this->table_name;
        
        if ($succursale && $succursale !== 'direction') {
            $query .= " WHERE succursale_rattachee = :succursale";
        }
        
        $query .= " ORDER BY date_inscription DESC";

        $stmt = $this->conn->prepare($query);
        
        if ($succursale && $succursale !== 'direction') {
            $stmt->bindParam(":succursale", $succursale);
        }

        $stmt->execute();
        return $stmt;
    }

    /**
     * Get single client details
     * @return void
     */
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->nom = $row['nom'];
            $this->prenom = $row['prenom'];
            $this->telephone = $row['telephone'];
            $this->email = $row['email'];
            $this->adresse = $row['adresse'];
            $this->ville = $row['ville'];
            $this->date_naissance = $row['date_naissance'];
            $this->numero_cni = $row['numero_cni'];
            $this->succursale_rattachee = $row['succursale_rattachee'];
            $this->date_inscription = $row['date_inscription'];
        }
    }

    /**
     * Update client
     * @return bool
     */
    public function update() {
        $query = "UPDATE " . $this->table_name . "
                SET
                    nom = :nom,
                    prenom = :prenom,
                    telephone = :telephone,
                    email = :email,
                    adresse = :adresse,
                    ville = :ville,
                    date_naissance = :date_naissance,
                    numero_cni = :numero_cni,
                    succursale_rattachee = :succursale_rattachee
                WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->prenom = htmlspecialchars(strip_tags($this->prenom));
        $this->telephone = htmlspecialchars(strip_tags($this->telephone));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->adresse = htmlspecialchars(strip_tags($this->adresse));
        $this->ville = htmlspecialchars(strip_tags($this->ville));
        $this->date_naissance = htmlspecialchars(strip_tags($this->date_naissance));
        $this->numero_cni = htmlspecialchars(strip_tags($this->numero_cni));
        $this->succursale_rattachee = htmlspecialchars(strip_tags($this->succursale_rattachee));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind
        $stmt->bindParam(":nom", $this->nom);
        $stmt->bindParam(":prenom", $this->prenom);
        $stmt->bindParam(":telephone", $this->telephone);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":adresse", $this->adresse);
        $stmt->bindParam(":ville", $this->ville);
        $stmt->bindParam(":date_naissance", $this->date_naissance);
        $stmt->bindParam(":numero_cni", $this->numero_cni);
        $stmt->bindParam(":succursale_rattachee", $this->succursale_rattachee);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    /**
     * Delete client
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
