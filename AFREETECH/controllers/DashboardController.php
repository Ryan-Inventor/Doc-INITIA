<?php
require_once __DIR__ . '/../config/database.php';

class DashboardController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            redirect('login');
        }
    }

    public function index() {
        $succursale = $_SESSION['user_succursale'];
        
        // Stats Clients
        $queryClients = "SELECT COUNT(*) as total FROM clients";
        if ($succursale !== 'direction') {
            $queryClients .= " WHERE succursale_rattachee = '$succursale'";
        }
        $stmtClients = $this->db->query($queryClients);
        $totalClients = $stmtClients->fetch(PDO::FETCH_ASSOC)['total'];

        // Stats Assurances Actives
        $queryAssurances = "SELECT COUNT(*) as total FROM assurances WHERE statut = 'active'";
        if ($succursale !== 'direction') {
            $queryAssurances .= " AND succursale_gestion = '$succursale'";
        }
        $stmtAssurances = $this->db->query($queryAssurances);
        $totalAssurances = $stmtAssurances->fetch(PDO::FETCH_ASSOC)['total'];

        // Stats Revenus (Montant total des primes actives)
        $queryRevenus = "SELECT SUM(montant_prime) as total FROM assurances WHERE statut = 'active'";
        if ($succursale !== 'direction') {
            $queryRevenus .= " AND succursale_gestion = '$succursale'";
        }
        $stmtRevenus = $this->db->query($queryRevenus);
        $totalRevenus = $stmtRevenus->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        require __DIR__ . '/../views/dashboard/index.php';
    }
}
