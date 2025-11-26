# INTIA Assurance Web Application

Application web de gestion pour la société INTIA Assurance, permettant la gestion centralisée des clients et des contrats d'assurance pour la direction générale et les succursales (Douala, Yaoundé).

## Fonctionnalités

- **Authentification** : Accès sécurisé par rôle (Admin/Direction, Gestionnaire/Succursale).
- **Gestion des Clients** : Ajout, modification, suppression et consultation des clients.
- **Gestion des Assurances** : Création et suivi des contrats d'assurance (Auto, Habitation, Santé, Vie).
- **Tableau de Bord** : Statistiques en temps réel sur les clients, contrats actifs et revenus.
- **Multi-Succursales** : Ségrégation des données par succursale (Douala/Yaoundé) avec vue globale pour la Direction.

## Architecture

Le projet suit une architecture **MVC (Model-View-Controller)** simple en PHP natif :

- **Models** : `models/` (Logique de données)
- **Controllers** : `controllers/` (Logique métier)
- **Views** : `views/` (Interface utilisateur avec Tailwind CSS)
- **Config** : `config/` (Configuration base de données)
- **Public** : `public/` (Point d'entrée et assets)

## Prérequis

- PHP 8.0+
- MySQL 8.0+
- Serveur Web (Apache/Nginx) ou PHP Built-in Server

## Installation

1.  **Cloner le projet** ou extraire les fichiers.
2.  **Base de Données** :
    - Créer une base de données nommée `intia_assurance`.
    - Importer le fichier `database.sql` pour créer les tables et l'utilisateur admin par défaut.
3.  **Configuration** :
    - Vérifier les paramètres de connexion dans `config/database.php`.
4.  **Lancement** :
    - Via PHP Built-in Server :
      ```bash
      cd public
      php -S localhost:8000
      ```
    - Accéder à `http://localhost:8000`.

## Tests

Pour exécuter les tests unitaires :

```bash
php tests/TestRunner.php
```

## Identifiants par défaut

- **Email** : `admin@intia.com`
- **Mot de passe** : `admin123`

## Auteur

Développé pour INTIA Assurance.
