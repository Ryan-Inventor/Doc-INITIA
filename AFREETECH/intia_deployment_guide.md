# GUIDE D'INSTALLATION ET DÉPLOIEMENT
## Application INTIA Assurance

---

## 1. PRÉREQUIS SYSTÈME

### 1.1 Configuration Minimale Serveur

**Serveur Web:**
- **OS**: Ubuntu 20.04 LTS / 22.04 LTS ou Windows Server 2019+
- **Processeur**: 2 CPU cores minimum
- **RAM**: 4 GB minimum (8 GB recommandé)
- **Disque**: 20 GB d'espace libre minimum
- **Connexion**: Accès Internet pour téléchargements initiaux

**Logiciels Requis:**
- **Serveur Web**: Apache 2.4+ ou Nginx 1.18+
- **PHP**: Version 8.0 ou supérieure
- **MySQL**: Version 8.0 ou supérieure
- **Composer**: Dernière version (optionnel, pour dépendances futures)
- **Git**: Pour cloner le projet (ou téléchargement ZIP)

### 1.2 Extensions PHP Requises

```bash
php8.0-cli
php8.0-common
php8.0-mysql
php8.0-mbstring
php8.0-xml
php8.0-curl
php8.0-zip
php8.0-gd
php8.0-json
```

### 1.3 Navigateurs Supportés (Clients)
- Google Chrome 90+
- Mozilla Firefox 88+
- Microsoft Edge 90+
- Safari 14+

---

## 2. INSTALLATION SUR SERVEUR LINUX (Ubuntu)

### 2.1 Mise à Jour du Système

```bash
# Mettre à jour les paquets système
sudo apt update && sudo apt upgrade -y
```

### 2.2 Installation d'Apache

```bash
# Installer Apache
sudo apt install apache2 -y

# Démarrer et activer Apache
sudo systemctl start apache2
sudo systemctl enable apache2

# Vérifier le statut
sudo systemctl status apache2
```

### 2.3 Installation de PHP 8.0+

```bash
# Ajouter le dépôt PHP
sudo apt install software-properties-common -y
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update

# Installer PHP et extensions
sudo apt install php8.0 php8.0-cli php8.0-common php8.0-mysql \
php8.0-mbstring php8.0-xml php8.0-curl php8.0-zip php8.0-gd \
php8.0-json libapache2-mod-php8.0 -y

# Vérifier l'installation
php -v
```

### 2.4 Installation de MySQL

```bash
# Installer MySQL Server
sudo apt install mysql-server -y

# Démarrer MySQL
sudo systemctl start mysql
sudo systemctl enable mysql

# Sécuriser l'installation MySQL
sudo mysql_secure_installation
```

**Configuration de sécurité MySQL:**
- Définir un mot de passe root fort
- Supprimer les utilisateurs anonymes: **Oui**
- Interdire la connexion root à distance: **Oui**
- Supprimer la base de données test: **Oui**
- Recharger les privilèges: **Oui**

### 2.5 Configuration de la Base de Données

```bash
# Se connecter à MySQL
sudo mysql -u root -p

# Exécuter les commandes SQL suivantes:
```

```sql
-- Créer la base de données
CREATE DATABASE intia_assurance CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Créer l'utilisateur dédié
CREATE USER 'intia_user'@'localhost' IDENTIFIED BY 'MotDePasseSecurise123!';

-- Accorder les privilèges
GRANT ALL PRIVILEGES ON intia_assurance.* TO 'intia_user'@'localhost';

-- Appliquer les changements
FLUSH PRIVILEGES;

-- Quitter MySQL
EXIT;
```

### 2.6 Création des Tables

```bash
# Importer le fichier SQL de création des tables
mysql -u intia_user -p intia_assurance < /chemin/vers/database.sql
```

**Contenu du fichier `database.sql`:**

```sql
-- Table utilisateurs
CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    role ENUM('admin', 'gestionnaire') DEFAULT 'gestionnaire',
    succursale ENUM('direction', 'douala', 'yaounde') NOT NULL,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table clients
CREATE TABLE clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    email VARCHAR(150) NOT NULL,
    adresse TEXT,
    ville VARCHAR(100),
    date_naissance DATE,
    numero_cni VARCHAR(50) NOT NULL UNIQUE,
    succursale_rattachee ENUM('douala', 'yaounde') NOT NULL,
    date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email_client (email),
    INDEX idx_cni (numero_cni),
    INDEX idx_succursale (succursale_rattachee)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table assurances
CREATE TABLE assurances (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    type_assurance ENUM('auto', 'habitation', 'sante', 'vie') NOT NULL,
    numero_contrat VARCHAR(50) NOT NULL UNIQUE,
    montant_prime DECIMAL(10,2) NOT NULL,
    date_souscription DATE NOT NULL,
    date_expiration DATE NOT NULL,
    statut ENUM('active', 'expiree', 'resiliee') DEFAULT 'active',
    succursale_gestion ENUM('douala', 'yaounde') NOT NULL,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE RESTRICT,
    INDEX idx_client (client_id),
    INDEX idx_numero_contrat (numero_contrat),
    INDEX idx_statut (statut),
    INDEX idx_succursale_ass (succursale_gestion)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertion utilisateur admin par défaut
INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, role, succursale) 
VALUES ('Admin', 'Système', 'admin@intia.cm', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'direction');
-- Mot de passe par défaut: Admin123!
```

### 2.7 Déploiement de l'Application

```bash
# Se déplacer dans le répertoire web
cd /var/www/html

# Cloner le projet (ou télécharger et extraire le ZIP)
sudo git clone https://github.com/votre-repo/intia-assurance.git
# OU
sudo unzip intia-assurance.zip

# Renommer le dossier
sudo mv intia-assurance intia

# Définir les permissions
sudo chown -R www-data:www-data /var/www/html/intia
sudo chmod -R 755 /var/www/html/intia

# Créer le dossier pour les logs
sudo mkdir -p /var/www/html/intia/logs
sudo chmod 777 /var/www/html/intia/logs
```

### 2.8 Configuration de l'Application

```bash
# Éditer le fichier de configuration de la base de données
sudo nano /var/www/html/intia/config/database.php
```

**Contenu du fichier `config/database.php`:**

```php
<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'intia_assurance');
define('DB_USER', 'intia_user');
define('DB_PASS', 'MotDePasseSecurise123!');
define('DB_CHARSET', 'utf8mb4');

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET,
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $e) {
    error_log("Erreur de connexion à la base de données: " . $e->getMessage());
    die("Erreur de connexion à la base de données. Veuillez contacter l'administrateur.");
}
?>
```

### 2.9 Configuration d'Apache

```bash
# Créer un fichier de configuration VirtualHost
sudo nano /etc/apache2/sites-available/intia.conf
```

**Contenu du fichier `intia.conf`:**

```apache
<VirtualHost *:80>
    ServerName intia.local
    ServerAlias www.intia.local
    DocumentRoot /var/www/html/intia/public

    <Directory /var/www/html/intia/public>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/intia_error.log
    CustomLog ${APACHE_LOG_DIR}/intia_access.log combined
</VirtualHost>
```

```bash
# Activer le module rewrite et le site
sudo a2enmod rewrite
sudo a2ensite intia.conf

# Désactiver le site par défaut (optionnel)
sudo a2dissite 000-default.conf

# Redémarrer Apache
sudo systemctl restart apache2
```

### 2.10 Configuration du fichier .htaccess

```bash
# Créer le fichier .htaccess dans /var/www/html/intia/public
sudo nano /var/www/html/intia/public/.htaccess
```

**Contenu du fichier `.htaccess`:**

```apache
# Activer le moteur de réécriture
RewriteEngine On

# Rediriger toutes les requêtes vers index.php
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]

# Sécurité: bloquer l'accès aux fichiers sensibles
<FilesMatch "\.(env|sql|log|md)$">
    Order allow,deny
    Deny from all
</FilesMatch>

# Désactiver le listing des répertoires
Options -Indexes

# Protection XSS
<IfModule mod_headers.c>
    Header set X-XSS-Protection "1; mode=block"
    Header set X-Content-Type-Options "nosniff"
    Header set X-Frame-Options "SAMEORIGIN"
</IfModule>
```

---

## 3. INSTALLATION SUR SERVEUR WINDOWS

### 3.1 Installation de XAMPP

1. **Télécharger XAMPP** depuis https://www.apachefriends.org
2. **Installer XAMPP** dans `C:\xampp`
3. **Démarrer** les modules Apache et MySQL depuis le panneau de contrôle XAMPP

### 3.2 Configuration de la Base de Données

1. Accéder à **phpMyAdmin**: http://localhost/phpmyadmin
2. Créer une nouvelle base de données: `intia_assurance`
3. Importer le fichier `database.sql`
4. Créer l'utilisateur `intia_user` avec les privilèges appropriés

### 3.3 Déploiement de l'Application

```batch
# Copier les fichiers de l'application dans
C:\xampp\htdocs\intia

# Éditer le fichier de configuration
C:\xampp\htdocs\intia\config\database.php
```

Modifier les paramètres selon votre configuration XAMPP.

### 3.4 Accès à l'Application

Ouvrir le navigateur: `http://localhost/intia/public/`

---

## 4. CONFIGURATION SSL/HTTPS (PRODUCTION)

### 4.1 Installation de Certbot (Let's Encrypt)

```bash
# Installer Certbot
sudo apt install certbot python3-certbot-apache -y

# Obtenir un certificat SSL
sudo certbot --apache -d votredomaine.com -d www.votredomaine.com

# Le renouvellement automatique est configuré par défaut
# Tester le renouvellement
sudo certbot renew --dry-run
```

### 4.2 Configuration HTTPS dans Apache

Le fichier de configuration sera automatiquement modifié par Certbot pour inclure:

```apache
<VirtualHost *:443>
    ServerName votredomaine.com
    DocumentRoot /var/www/html/intia/public

    SSLEngine on
    SSLCertificateFile /etc/letsencrypt/live/votredomaine.com/fullchain.pem
    SSLCertificateKeyFile /etc/letsencrypt/live/votredomaine.com/privkey.pem

    # ... reste de la configuration
</VirtualHost>
```

---

## 5. CONFIGURATION DE SÉCURITÉ AVANCÉE

### 5.1 Configuration PHP (php.ini)

```bash
sudo nano /etc/php/8.0/apache2/php.ini
```

**Paramètres recommandés:**

```ini
# Désactiver l'affichage des erreurs en production
display_errors = Off
log_errors = On
error_log = /var/log/php/error.log

# Limites de sécurité
max_execution_time = 30
max_input_time = 60
memory_limit = 128M
post_max_size = 20M
upload_max_filesize = 20M

# Sécurité sessions
session.cookie_httponly = 1
session.cookie_secure = 1
session.use_strict_mode = 1
```

```bash
# Créer le dossier de logs PHP
sudo mkdir -p /var/log/php
sudo chown www-data:www-data /var/log/php

# Redémarrer Apache
sudo systemctl restart apache2
```

### 5.2 Configuration du Pare-feu (UFW)

```bash
# Activer UFW
sudo ufw enable

# Autoriser SSH (important!)
sudo ufw allow 22/tcp

# Autoriser HTTP et HTTPS
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp

# Vérifier le statut
sudo ufw status
```

### 5.3 Sécurisation MySQL

```bash
# Éditer la configuration MySQL
sudo nano /etc/mysql/mysql.conf.d/mysqld.cnf
```

**Ajouter/modifier:**

```ini
[mysqld]
# N'écouter que sur localhost
bind-address = 127.0.0.1

# Désactiver le chargement de fichiers locaux
local-infile = 0
```

```bash
# Redémarrer MySQL
sudo systemctl restart mysql
```

---

## 6. SAUVEGARDE ET RESTAURATION

### 6.1 Script de Sauvegarde Automatique

```bash
# Créer le script de sauvegarde
sudo nano /usr/local/bin/backup_intia.sh
```

**Contenu du script:**

```bash
#!/bin/bash

# Configuration
BACKUP_DIR="/var/backups/intia"
DB_NAME="intia_assurance"
DB_USER="intia_user"
DB_PASS="MotDePasseSecurise123!"
DATE=$(date +%Y%m%d_%H%M%S)

# Créer le répertoire de sauvegarde
mkdir -p $BACKUP_DIR

# Sauvegarde de la base de données
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME | gzip > $BACKUP_DIR/db_backup_$DATE.sql.gz

# Sauvegarde des fichiers de l'application
tar -czf $BACKUP_DIR/files_backup_$DATE.tar.gz /var/www/html/intia

# Supprimer les sauvegardes de plus de 7 jours
find $BACKUP_DIR -type f -mtime +7 -delete

echo "Sauvegarde terminée: $DATE"
```

```bash
# Rendre le script exécutable
sudo chmod +x /usr/local/bin/backup_intia.sh

# Configurer une tâche cron quotidienne (2h du matin)
sudo crontab -e

# Ajouter la ligne:
0 2 * * * /usr/local/bin/backup_intia.sh >> /var/log/intia_backup.log 2>&1
```

### 6.2 Restauration depuis une Sauvegarde

```bash
# Restaurer la base de données
gunzip < /var/backups/intia/db_backup_20250115_020000.sql.gz | mysql -u intia_user -p intia_assurance

# Restaurer les fichiers
sudo tar -xzf /var/backups/intia/files_backup_20250115_020000.tar.gz -C /
```

---

## 7. VÉRIFICATIONS POST-INSTALLATION

### 7.1 Checklist de Vérification

```bash
# 1. Vérifier Apache
sudo systemctl status apache2

# 2. Vérifier PHP
php -v

# 3. Vérifier MySQL
sudo systemctl status mysql

# 4. Tester la connexion à la base de données
mysql -u intia_user -p intia_assurance -e "SHOW TABLES;"

# 5. Vérifier les permissions
ls -la /var/www/html/intia

# 6. Vérifier les logs Apache
sudo tail -f /var/log/apache2/intia_error.log
```

### 7.2 Tests Fonctionnels

1. **Accéder à l'application**: http://votredomaine.com ou http://localhost/intia/public/
2. **Tester la connexion**:
   - Email: `admin@intia.cm`
   - Mot de passe: `Admin123!`
3. **Vérifier toutes les pages** (Dashboard, Clients, Assurances)
4. **Tester l'ajout d'un client** pour valider la base de données
5. **Vérifier le responsive** sur mobile/tablette

---

## 8. MAINTENANCE

### 8.1 Mise à Jour de l'Application

```bash
# Sauvegarder avant la mise à jour
/usr/local/bin/backup_intia.sh

# Télécharger la nouvelle version
cd /var/www/html
sudo git pull origin main
# OU
sudo unzip nouvelle_version.zip

# Appliquer les migrations de base de données si nécessaire
mysql -u intia_user -p intia_assurance < migrations/update_v2.sql

# Vider le cache (si applicable)
sudo rm -rf /var/www/html/intia/cache/*

# Redémarrer Apache
sudo systemctl restart apache2
```

### 8.2 Monitoring

```bash
# Surveiller l'utilisation disque
df -h

# Surveiller l'utilisation mémoire
free -m

# Surveiller les processus Apache
sudo apachectl status

# Surveiller les connexions MySQL
mysql -u root -p -e "SHOW PROCESSLIST;"
```

### 8.3 Logs à Surveiller

- Apache: `/var/log/apache2/intia_error.log`
- PHP: `/var/log/php/error.log`
- MySQL: `/var/log/mysql/error.log`
- Application: `/var/www/html/intia/logs/app.log`

---

## 9. DÉPANNAGE COURANT

### 9.1 Erreur 500 - Internal Server Error

**Causes possibles:**
- Permissions incorrectes
- Erreur dans le code PHP
- Configuration Apache incorrecte

**Solutions:**
```bash
# Vérifier les logs
sudo tail -50 /var/log/apache2/intia_error.log

# Corriger les permissions
sudo chown -R www-data:www-data /var/www/html/intia
sudo chmod -R 755 /var/www/html/intia
```

### 9.2 Erreur de Connexion à la Base de Données

**Solutions:**
```bash
# Vérifier que MySQL est démarré
sudo systemctl status mysql

# Tester la connexion
mysql -u intia_user -p intia_assurance

# Vérifier les identifiants dans config/database.php
```

### 9.3 Page Blanche (White Screen)

**Solutions:**
```bash
# Activer l'affichage des erreurs temporairement
sudo nano /etc/php/8.0/apache2/php.ini
# Changer: display_errors = On

# Redémarrer Apache
sudo systemctl restart apache2

# Consulter les erreurs PHP
sudo tail -50 /var/log/php/error.log
```

---

## 10. CONTACTS ET SUPPORT

**Support Technique:**
- Email: support@intia.cm
- Téléphone: +237 6XX XX XX XX

**Documentation:**
- Guide utilisateur: /docs/user_manual.pdf
- Documentation technique: /docs/technical_docs.pdf

**Développeur:**
- Nom: [Votre Nom]
- Email: dev@intia.cm

---

## ANNEXE: COMMANDES UTILES

```bash
# Redémarrer tous les services
sudo systemctl restart apache2
sudo systemctl restart mysql

# Voir l'utilisation des ressources
htop

# Nettoyer les logs anciens
sudo find /var/log -type f -name "*.log" -mtime +30 -delete

# Sauvegarder manuellement
/usr/local/bin/backup_intia.sh

# Vérifier la configuration Apache
sudo apache2ctl configtest

# Recharger Apache sans interruption
sudo systemctl reload apache2
```