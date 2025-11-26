# SPÉCIFICATIONS TECHNIQUES
## Application de Gestion INTIA Assurance

---

## 1. PRÉSENTATION DU PROJET

### 1.1 Contexte
La société INTIA Assurance souhaite moderniser la gestion de ses données clients et contrats d'assurance à travers une application web centralisée. L'entreprise dispose d'une direction générale et de deux succursales (INTIA-Douala et INTIA-Yaoundé) qui nécessitent un accès unifié aux informations.

### 1.2 Objectifs
- Centraliser la gestion des clients et des contrats d'assurance
- Permettre les opérations CRUD (Create, Read, Update, Delete) sur les données
- Assurer une interface utilisateur intuitive et responsive
- Garantir la sécurité et l'intégrité des données

---

## 2. ARCHITECTURE TECHNIQUE

### 2.1 Architecture Générale
L'application suit le pattern **MVC (Model-View-Controller)** pour assurer une séparation claire des responsabilités :

- **Model** : Gestion des données (clients, assurances, utilisateurs)
- **View** : Interface utilisateur (HTML + Tailwind CSS)
- **Controller** : Logique métier et traitement des requêtes (PHP)

### 2.2 Technologies Utilisées

| Composant | Technologie | Version Recommandée |
|-----------|-------------|---------------------|
| Front-end | HTML5, Tailwind CSS, JavaScript | Tailwind 3.x |
| Back-end | PHP | 8.0+ |
| Base de données | MySQL | 8.0+ |
| Serveur Web | Apache/Nginx | - |

---

## 3. STRUCTURE DE LA BASE DE DONNÉES

### 3.1 Schéma des Tables Principales

**Table `utilisateurs`**
```
- id (INT, PRIMARY KEY, AUTO_INCREMENT)
- nom (VARCHAR 100)
- prenom (VARCHAR 100)
- email (VARCHAR 150, UNIQUE)
- mot_de_passe (VARCHAR 255, hashé)
- role (ENUM: 'admin', 'gestionnaire')
- succursale (ENUM: 'direction', 'douala', 'yaounde')
- date_creation (DATETIME)
```

**Table `clients`**
```
- id (INT, PRIMARY KEY, AUTO_INCREMENT)
- nom (VARCHAR 100)
- prenom (VARCHAR 100)
- telephone (VARCHAR 20)
- email (VARCHAR 150)
- adresse (TEXT)
- ville (VARCHAR 100)
- date_naissance (DATE)
- numero_cni (VARCHAR 50, UNIQUE)
- succursale_rattachee (ENUM: 'douala', 'yaounde')
- date_inscription (DATETIME)
```

**Table `assurances`**
```
- id (INT, PRIMARY KEY, AUTO_INCREMENT)
- client_id (INT, FOREIGN KEY -> clients.id)
- type_assurance (ENUM: 'auto', 'habitation', 'sante', 'vie')
- numero_contrat (VARCHAR 50, UNIQUE)
- montant_prime (DECIMAL 10,2)
- date_souscription (DATE)
- date_expiration (DATE)
- statut (ENUM: 'active', 'expiree', 'resiliee')
- succursale_gestion (ENUM: 'douala', 'yaounde')
```

### 3.2 Relations
- Un client peut avoir plusieurs contrats d'assurance (relation 1:N)
- Chaque assurance est liée à un seul client
- Les utilisateurs sont rattachés à une succursale spécifique

---

## 4. ARCHITECTURE MVC

### 4.1 Structure des Dossiers
```
/intia-assurance
│
├── /config
│   └── database.php          # Configuration BDD
│
├── /models
│   ├── Client.php            # Modèle Client
│   ├── Assurance.php         # Modèle Assurance
│   └── Utilisateur.php       # Modèle Utilisateur
│
├── /controllers
│   ├── ClientController.php
│   ├── AssuranceController.php
│   └── AuthController.php
│
├── /views
│   ├── /layouts
│   │   ├── header.php
│   │   └── footer.php
│   ├── /clients
│   │   ├── index.php         # Liste clients
│   │   ├── create.php        # Formulaire ajout
│   │   └── edit.php          # Formulaire modification
│   ├── /assurances
│   │   ├── index.php
│   │   ├── create.php
│   │   └── edit.php
│   └── /auth
│       └── login.php
│
├── /public
│   ├── /css
│   │   └── style.css         # Styles personnalisés
│   ├── /js
│   │   └── app.js            # Scripts JS
│   └── index.php             # Point d'entrée
│
└── /assets
    └── /images
```

### 4.2 Fonctionnement
1. **Routage** : Le fichier `index.php` analyse l'URL et redirige vers le contrôleur approprié
2. **Contrôleur** : Reçoit la requête, interagit avec le modèle et charge la vue
3. **Modèle** : Effectue les opérations en base de données
4. **Vue** : Affiche les données avec Tailwind CSS

---

## 5. FONCTIONNALITÉS PRINCIPALES

### 5.1 Gestion des Clients
- **Ajouter** : Formulaire de saisie avec validation (nom, prénom, téléphone, email, adresse, ville, date de naissance, CNI, succursale)
- **Consulter** : Liste paginée avec recherche et filtres (par succursale, ville)
- **Modifier** : Édition des informations existantes
- **Supprimer** : Suppression avec confirmation (vérification des contrats liés)

### 5.2 Gestion des Assurances
- **Ajouter** : Création de contrat lié à un client avec type, montant, dates, succursale
- **Consulter** : Tableau des contrats avec statut et filtres (type, statut, succursale)
- **Modifier** : Mise à jour des informations contractuelles
- **Supprimer** : Suppression avec confirmation

### 5.3 Authentification et Sécurité
- Connexion sécurisée (email/mot de passe hashé avec `password_hash()`)
- Gestion des sessions PHP
- Contrôle d'accès basé sur les rôles (admin/gestionnaire)
- Protection CSRF pour les formulaires
- Validation et échappement des données (PDO avec requêtes préparées)

### 5.4 Dashboard
- Statistiques globales : nombre de clients, contrats actifs, revenus
- Répartition par succursale (Douala, Yaoundé)
- Graphiques visuels (avec Chart.js ou similaire)

---

## 6. INTERFACE UTILISATEUR

### 6.1 Design
- **Framework CSS** : Tailwind CSS pour un design moderne et responsive
- **Composants** : Formulaires, tableaux, modales, alertes
- **Palette de couleurs** : Bleu professionnel (tons d'assurance et confiance)
- **Responsive** : Compatible desktop, tablette, mobile

### 6.2 Navigation
- Menu principal : Dashboard, Clients, Assurances, Utilisateurs (admin)
- Barre de recherche globale
- Indicateur de succursale active
- Bouton de déconnexion

---

## 7. SÉCURITÉ ET PERFORMANCES

### 7.1 Mesures de Sécurité
- Hachage des mots de passe (bcrypt)
- Requêtes préparées PDO (protection SQL injection)
- Validation côté serveur et client
- Tokens CSRF pour les formulaires
- Sessions sécurisées avec expiration

### 7.2 Optimisation
- Indexation des colonnes clés (email, numero_contrat, client_id)
- Pagination des résultats (20 éléments par page)
- Cache des requêtes fréquentes
- Compression des assets (CSS/JS minifiés)

---

## 8. DÉPLOIEMENT

### 8.1 Prérequis Serveur
- PHP 8.0 ou supérieur
- MySQL 8.0 ou supérieur
- Apache/Nginx avec mod_rewrite
- HTTPS activé (certificat SSL)

### 8.2 Installation
1. Cloner le projet sur le serveur
2. Configurer `config/database.php` avec les identifiants BDD
3. Importer le script SQL de création de tables
4. Créer un compte administrateur par défaut
5. Configurer les permissions des dossiers (logs, uploads)

### 8.3 Maintenance
- Sauvegardes automatiques quotidiennes de la base de données
- Logs d'erreurs et d'activité utilisateur
- Mises à jour de sécurité régulières

---

## 9. LIVRABLES

- Code source complet (architecture MVC)
- Script SQL de création de base de données
- Documentation technique (README.md)
- Manuel utilisateur (PDF)
- Compte administrateur de test

---

## 10. ÉVOLUTIONS FUTURES

- Module de génération de rapports PDF
- Envoi d'emails automatiques (rappels d'échéance)
- Tableau de bord analytique avancé
- API REST pour intégration mobile
- Notifications en temps réel