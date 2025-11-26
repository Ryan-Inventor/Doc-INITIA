# GUIDE DE MISE SUR GIT ET ORGANISATION DU REPOSITORY

## STRUCTURE RECOMMANDÉE DU REPOSITORY

```
intia-assurance/
│
├── kk/                                    # Dossier pour tous les documents
│   ├── intia_specs_tech.md               # Spécifications techniques
│   ├── intia_deployment_guide.md         # Guide de déploiement
│   ├── intia_test_plan.md                # Plan de tests
│   ├── intia_monitoring_guide.md         # Guide de surveillance
│   ├── user_manual.pdf                   # Manuel utilisateur (si disponible)
│   └── database_schema.sql               # Script SQL complet
│
├── config/
│   ├── database.php
│   └── config.php
│
├── models/
│   ├── Client.php
│   ├── Assurance.php
│   └── Utilisateur.php
│
├── controllers/
│   ├── ClientController.php
│   ├── AssuranceController.php
│   └── AuthController.php
│
├── views/
│   ├── layouts/
│   │   ├── header.php
│   │   └── footer.php
│   ├── clients/
│   │   ├── index.php
│   │   ├── create.php
│   │   └── edit.php
│   ├── assurances/
│   │   ├── index.php
│   │   ├── create.php
│   │   └── edit.php
│   └── auth/
│       └── login.php
│
├── public/
│   ├── css/
│   │   └── style.css
│   ├── js/
│   │   └── app.js
│   ├── index.php
│   └── .htaccess
│
├── assets/
│   └── images/
│
├── logs/                                  # Vide (ignoré par Git)
│   └── .gitkeep
│
├── .gitignore
├── README.md
├── LICENSE
└── composer.json (optionnel)
```

## PROCÉDURE COMPLÈTE DE MISE SUR GIT

### ÉTAPE 1 : Préparation du Projet

```bash
# Se positionner dans le dossier du projet
cd /chemin/vers/intia-assurance

# Créer le dossier kk à la racine
mkdir -p kk

# Déplacer tous les documents dans kk/
mv intia_specs_tech.md kk/
mv intia_deployment_guide.md kk/
mv intia_test_plan.md kk/
# Ajouter les autres documents...
```

### ÉTAPE 2 : Créer le fichier .gitignore

```bash
# Créer .gitignore à la racine
nano .gitignore
```

**Contenu du fichier `.gitignore` :**

```gitignore
# Fichiers de configuration sensibles
config/database.php
config/.env

# Logs
logs/*.log
logs/*
!logs/.gitkeep

# Cache
cache/*
!cache/.gitkeep

# Uploads utilisateurs
uploads/*
!uploads/.gitkeep

# Fichiers système
.DS_Store
Thumbs.db
*.swp
*.swo
*~

# IDE
.vscode/
.idea/
*.sublime-project
*.sublime-workspace

# Dépendances (si utilisation de Composer)
/vendor/

# Fichiers temporaires
*.tmp
*.bak
*.old

# Sauvegardes de base de données
*.sql.gz
backups/
```

### ÉTAPE 3 : Créer un fichier README.md

```bash
nano README.md
```

**Contenu du `README.md` :**

```markdown
# Application INTIA Assurance

Application web de gestion de clients et contrats d'assurance pour INTIA Assurance (Douala & Yaoundé).

## 🎯 Fonctionnalités

- Gestion complète des clients (CRUD)
- Gestion des contrats d'assurance (Auto, Habitation, Santé, Vie)
- Dashboard avec statistiques par succursale
- Authentification sécurisée avec gestion des rôles
- Interface responsive (Desktop, Tablette, Mobile)

## 🛠️ Technologies

- **Backend** : PHP 8.0+
- **Frontend** : HTML5, Tailwind CSS, JavaScript
- **Base de données** : MySQL 8.0+
- **Serveur** : Apache/Nginx
- **Architecture** : MVC (Model-View-Controller)

## 📋 Prérequis

- PHP 8.0 ou supérieur
- MySQL 8.0 ou supérieur
- Apache/Nginx avec mod_rewrite activé
- Extensions PHP : mysqli, pdo, mbstring, json

## 🚀 Installation

Consulter le guide complet dans : `kk/intia_deployment_guide.md`

### Installation Rapide

```bash
# 1. Cloner le repository
git clone https://github.com/votre-username/intia-assurance.git
cd intia-assurance

# 2. Créer la base de données
mysql -u root -p < kk/database_schema.sql

# 3. Configurer la connexion BDD
cp config/database.example.php config/database.php
nano config/database.php

# 4. Définir les permissions
chmod -R 755 .
chmod -R 777 logs/

# 5. Accéder à l'application
http://localhost/intia-assurance/public/
```

## 👤 Compte de Test

- **Email** : admin@intia.cm
- **Mot de passe** : Admin123!

## 📚 Documentation

Tous les documents sont disponibles dans le dossier `kk/` :

- **Spécifications techniques** : `kk/intia_specs_tech.md`
- **Guide de déploiement** : `kk/intia_deployment_guide.md`
- **Plan de tests** : `kk/intia_test_plan.md`
- **Guide de surveillance** : `kk/intia_monitoring_guide.md`

## 🗂️ Structure du Projet

```
intia-assurance/
├── kk/                    # Documentation complète
├── config/                # Configuration (BDD, etc.)
├── models/                # Modèles (Client, Assurance, Utilisateur)
├── controllers/           # Contrôleurs MVC
├── views/                 # Vues (interface utilisateur)
├── public/                # Point d'entrée & assets publics
└── logs/                  # Logs d'application
```

## 🔒 Sécurité

- Mots de passe hashés avec `password_hash()` (bcrypt)
- Requêtes préparées PDO (protection SQL injection)
- Protection CSRF sur tous les formulaires
- Validation côté serveur et client
- Sessions sécurisées avec expiration

## 🧪 Tests

Plan de tests complet disponible dans `kk/intia_test_plan.md`

Exécuter les tests :
```bash
# Tests fonctionnels manuels selon le plan
# Tests de sécurité (injection SQL, XSS, CSRF)
# Tests de performance
```

## 📊 Monitoring

Configuration de surveillance détaillée dans `kk/intia_monitoring_guide.md`

## 🤝 Contribution

1. Fork le projet
2. Créer une branche (`git checkout -b feature/AmazingFeature`)
3. Commit les changes (`git commit -m 'Add AmazingFeature'`)
4. Push vers la branche (`git push origin feature/AmazingFeature`)
5. Ouvrir une Pull Request

## 📝 Licence

Ce projet est sous licence propriétaire - INTIA Assurance © 2025

## 📞 Support

- **Email** : support@intia.cm
- **Téléphone** : +237 6XX XX XX XX

## 👨‍💻 Auteur

Développé par [Votre Nom] - [votre-email@example.com]
```

### ÉTAPE 4 : Créer un fichier database.example.php

```bash
# Créer un exemple de configuration (sans données sensibles)
nano config/database.example.php
```

**Contenu :**

```php
<?php
// EXEMPLE DE CONFIGURATION - Copier vers database.php et modifier
define('DB_HOST', 'localhost');
define('DB_NAME', 'intia_assurance');
define('DB_USER', 'votre_utilisateur');
define('DB_PASS', 'votre_mot_de_passe');
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
    die("Erreur de connexion à la base de données.");
}
?>
```

### ÉTAPE 5 : Initialiser Git

```bash
# Initialiser le repository Git
git init

# Ajouter tous les fichiers (sauf ceux dans .gitignore)
git add .

# Vérifier les fichiers ajoutés
git status

# Premier commit
git commit -m "Initial commit: Application INTIA Assurance avec documentation complète"
```

### ÉTAPE 6 : Créer le Repository sur GitHub

**Option A : Via Interface GitHub**

1. Aller sur https://github.com
2. Cliquer sur "+" → "New repository"
3. Nom : `intia-assurance`
4. Description : "Application de gestion INTIA Assurance"
5. Choisir : **Private** (ou Public selon vos besoins)
6. **NE PAS** cocher "Initialize with README" (vous en avez déjà un)
7. Cliquer "Create repository"

**Option B : Via GitHub CLI**

```bash
# Installer GitHub CLI si nécessaire
# Ubuntu/Debian
sudo apt install gh

# Se connecter
gh auth login

# Créer le repository
gh repo create intia-assurance --private --source=. --remote=origin --push
```

### ÉTAPE 7 : Lier et Pousser vers GitHub

```bash
# Ajouter le remote (remplacer YOUR_USERNAME)
git remote add origin https://github.com/YOUR_USERNAME/intia-assurance.git

# Vérifier le remote
git remote -v

# Pousser vers GitHub
git branch -M main
git push -u origin main
```

### ÉTAPE 8 : Vérifier l'Organisation

```bash
# Vérifier que le dossier kk contient tous les documents
ls -la kk/

# Devrait afficher :
# intia_specs_tech.md
# intia_deployment_guide.md
# intia_test_plan.md
# intia_monitoring_guide.md
# database_schema.sql
# (autres documents...)
```

## COMMANDES GIT UTILES POUR LA SUITE

### Ajouter de nouveaux fichiers

```bash
# Ajouter un fichier spécifique
git add chemin/vers/fichier.php

# Ajouter tous les changements
git add .

# Commiter
git commit -m "Description du changement"

# Pousser vers GitHub
git push origin main
```

### Ajouter un document dans kk/

```bash
# Créer ou copier le document dans kk/
cp nouveau_document.pdf kk/

# Ajouter au repository
git add kk/nouveau_document.pdf
git commit -m "Ajout nouveau document dans kk/"
git push origin main
```

### Gestion des branches

```bash
# Créer une branche de développement
git checkout -b develop

# Travailler sur la branche
git add .
git commit -m "Nouvelles fonctionnalités"
git push origin develop

# Fusionner dans main
git checkout main
git merge develop
git push origin main
```

### Mettre à jour depuis GitHub

```bash
# Récupérer les derniers changements
git pull origin main
```

## STRUCTURE FINALE SUR GITHUB

Une fois poussé, votre repository GitHub aura cette structure :

```
📁 intia-assurance (Repository)
│
├── 📁 kk/                                ← TOUS VOS DOCUMENTS ICI
│   ├── 📄 intia_specs_tech.md
│   ├── 📄 intia_deployment_guide.md
│   ├── 📄 intia_test_plan.md
│   └── 📄 intia_monitoring_guide.md
│
├── 📁 config/
├── 📁 models/
├── 📁 controllers/
├── 📁 views/
├── 📁 public/
├── 📄 .gitignore
├── 📄 README.md
└── 📄 LICENSE (optionnel)
```

## CONSEILS SUPPLÉMENTAIRES

### 1. Protéger la branche main

Sur GitHub :
- Settings → Branches → Add rule
- Branch name pattern : `main`
- Cocher "Require pull request reviews before merging"

### 2. Ajouter un fichier LICENSE

```bash
# Créer LICENSE à la racine
nano LICENSE
```

Exemple de licence propriétaire :
```
Copyright (c) 2025 INTIA Assurance

Tous droits réservés.

Ce logiciel est la propriété de INTIA Assurance.
Toute reproduction ou distribution est interdite sans autorisation écrite.
```

### 3. Créer un fichier CHANGELOG.md

```bash
nano CHANGELOG.md
```

```markdown
# Changelog

## [1.0.0] - 2025-01-15

### Ajouté
- Gestion complète des clients
- Gestion des contrats d'assurance
- Dashboard avec statistiques
- Authentification sécurisée
- Documentation complète dans kk/
```

## VÉRIFICATION FINALE

```bash
# Vérifier que tout est bien poussé
git log --oneline
git status

# Vérifier la structure sur GitHub
# Aller sur https://github.com/YOUR_USERNAME/intia-assurance
# Confirmer que le dossier kk/ est visible avec tous les documents
```

Votre code et documentation sont maintenant sur Git, organisés proprement avec tous les documents dans le dossier `kk/` à la racine ! 🎉