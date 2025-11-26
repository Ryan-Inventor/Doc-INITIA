-- Database creation script for INTIA Assurance

CREATE DATABASE IF NOT EXISTS intia_assurance;
USE intia_assurance;

-- Table: utilisateurs
CREATE TABLE IF NOT EXISTS utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    role ENUM('admin', 'gestionnaire') NOT NULL,
    succursale ENUM('direction', 'douala', 'yaounde') NOT NULL,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Table: clients
CREATE TABLE IF NOT EXISTS clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    email VARCHAR(150),
    adresse TEXT,
    ville VARCHAR(100),
    date_naissance DATE,
    numero_cni VARCHAR(50) UNIQUE,
    succursale_rattachee ENUM('douala', 'yaounde') NOT NULL,
    date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Table: assurances
CREATE TABLE IF NOT EXISTS assurances (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    type_assurance ENUM('auto', 'habitation', 'sante', 'vie') NOT NULL,
    numero_contrat VARCHAR(50) NOT NULL UNIQUE,
    montant_prime DECIMAL(10,2) NOT NULL,
    date_souscription DATE NOT NULL,
    date_expiration DATE NOT NULL,
    statut ENUM('active', 'expiree', 'resiliee') NOT NULL DEFAULT 'active',
    succursale_gestion ENUM('douala', 'yaounde') NOT NULL,
    FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE
);

-- Insert default admin user (Password: admin123)
-- Hash generated using password_hash('admin123', PASSWORD_BCRYPT)
INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, role, succursale) 
VALUES ('Admin', 'Principal', 'admin@intia.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'direction')
ON DUPLICATE KEY UPDATE email=email;
