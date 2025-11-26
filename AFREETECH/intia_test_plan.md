# PLAN DE TESTS FONCTIONNELS
## Application INTIA Assurance

---

## 1. STRATÉGIE DE TEST

### 1.1 Objectifs
- Valider que toutes les fonctionnalités répondent aux spécifications
- Garantir la sécurité et l'intégrité des données
- Vérifier la compatibilité multi-navigateurs et responsive
- S'assurer de la performance et de la stabilité

### 1.2 Périmètre
- Tests fonctionnels (modules clients, assurances, authentification)
- Tests de sécurité (injection SQL, XSS, CSRF)
- Tests d'interface utilisateur (UI/UX)
- Tests de performance (temps de réponse, charge)

### 1.3 Environnements de Test
- **Navigateurs** : Chrome, Firefox, Safari, Edge (dernières versions)
- **Appareils** : Desktop (1920x1080), Tablette (768px), Mobile (375px)
- **Serveur** : Environnement de développement identique à production

---

## 2. TESTS D'AUTHENTIFICATION

### 2.1 Connexion

| Test ID | Scénario | Données de Test | Résultat Attendu | Priorité |
|---------|----------|-----------------|-------------------|----------|
| AUTH-01 | Connexion avec identifiants valides | Email: admin@intia.cm<br>Mot de passe: Admin123! | Redirection vers dashboard | Critique |
| AUTH-02 | Connexion avec email invalide | Email: invalid@test.com<br>Mot de passe: Test123! | Message "Identifiants incorrects" | Critique |
| AUTH-03 | Connexion avec mot de passe incorrect | Email: admin@intia.cm<br>Mot de passe: WrongPass | Message "Identifiants incorrects" | Critique |
| AUTH-04 | Connexion avec champs vides | Email: vide<br>Mot de passe: vide | Messages de validation "Champs requis" | Haute |
| AUTH-05 | Tentatives multiples échouées | 5 tentatives incorrectes | Blocage temporaire du compte (5 min) | Haute |
| AUTH-06 | Connexion après session expirée | Session expirée (2h) | Redirection vers page de connexion | Moyenne |

### 2.2 Déconnexion

| Test ID | Scénario | Résultat Attendu | Priorité |
|---------|----------|-------------------|----------|
| AUTH-07 | Clic sur bouton déconnexion | Session détruite, redirection vers login | Critique |
| AUTH-08 | Accès page protégée après déconnexion | Redirection automatique vers login | Critique |

---

## 3. TESTS GESTION CLIENTS

### 3.1 Ajout de Client

| Test ID | Scénario | Données de Test | Résultat Attendu | Priorité |
|---------|----------|-----------------|-------------------|----------|
| CLI-01 | Ajout client avec données valides | Nom: KAMGA<br>Prénom: Jean<br>Tel: 237699123456<br>Email: jean@gmail.com<br>CNI: 123456789<br>Succursale: douala | Client créé, message de succès, redirection vers liste | Critique |
| CLI-02 | Ajout avec email déjà existant | Email: jean@gmail.com (doublon) | Message "Email déjà utilisé" | Critique |
| CLI-03 | Ajout avec CNI déjà existant | CNI: 123456789 (doublon) | Message "CNI déjà enregistré" | Critique |
| CLI-04 | Ajout avec champs obligatoires vides | Nom: vide, Prénom: vide | Messages de validation pour champs requis | Haute |
| CLI-05 | Ajout avec format email invalide | Email: invalid-email | Message "Format email invalide" | Haute |
| CLI-06 | Ajout avec téléphone invalide | Tel: 123 (trop court) | Message "Format téléphone invalide" | Moyenne |
| CLI-07 | Ajout avec date de naissance future | Date: 2026-01-01 | Message "Date invalide" | Moyenne |
| CLI-08 | Injection SQL dans formulaire | Nom: ' OR '1'='1 | Données échappées, pas d'injection | Critique |

### 3.2 Consultation de Clients

| Test ID | Scénario | Résultat Attendu | Priorité |
|---------|----------|-------------------|----------|
| CLI-09 | Affichage liste complète | Liste paginée (20 clients/page) avec toutes colonnes | Critique |
| CLI-10 | Recherche par nom | Saisie: "KAMGA" | Affichage clients correspondants uniquement | Haute |
| CLI-11 | Filtre par succursale | Sélection: Douala | Affichage clients de Douala uniquement | Haute |
| CLI-12 | Filtre par ville | Sélection: Yaoundé | Affichage clients de Yaoundé uniquement | Moyenne |
| CLI-13 | Pagination | Clic page 2 | Affichage 20 clients suivants | Moyenne |
| CLI-14 | Recherche sans résultat | Saisie: "ZZZZZZ" | Message "Aucun client trouvé" | Basse |
| CLI-15 | Affichage détails client | Clic sur un client | Affichage fiche complète avec contrats associés | Haute |

### 3.3 Modification de Client

| Test ID | Scénario | Données de Test | Résultat Attendu | Priorité |
|---------|----------|-----------------|-------------------|----------|
| CLI-16 | Modification données valides | Téléphone: 237677999888 | Client mis à jour, message de succès | Critique |
| CLI-17 | Modification avec email existant | Email d'un autre client | Message "Email déjà utilisé" | Critique |
| CLI-18 | Modification avec CNI existant | CNI d'un autre client | Message "CNI déjà enregistré" | Critique |
| CLI-19 | Annulation de modification | Clic "Annuler" | Retour liste sans modification | Basse |

### 3.4 Suppression de Client

| Test ID | Scénario | Résultat Attendu | Priorité |
|---------|----------|-------------------|----------|
| CLI-20 | Suppression client sans contrat | Modale de confirmation affichée | Critique |
| CLI-21 | Confirmation de suppression | Clic "Confirmer" | Client supprimé, message de succès | Critique |
| CLI-22 | Annulation de suppression | Clic "Annuler" | Client conservé | Moyenne |
| CLI-23 | Suppression client avec contrats actifs | Tentative de suppression | Message "Impossible, contrats actifs liés" | Critique |

---

## 4. TESTS GESTION ASSURANCES

### 4.1 Ajout d'Assurance

| Test ID | Scénario | Données de Test | Résultat Attendu | Priorité |
|---------|----------|-----------------|-------------------|----------|
| ASS-01 | Ajout assurance valide | Client: Jean KAMGA<br>Type: Auto<br>Prime: 150000<br>Dates: valides<br>Succursale: douala | Assurance créée, numéro contrat généré automatiquement | Critique |
| ASS-02 | Ajout avec montant négatif | Prime: -5000 | Message "Montant invalide" | Haute |
| ASS-03 | Ajout avec date expiration < souscription | Souscription: 2025-01-01<br>Expiration: 2024-12-31 | Message "Date expiration doit être postérieure" | Haute |
| ASS-04 | Ajout sans client sélectionné | Client: non sélectionné | Message "Client requis" | Critique |
| ASS-05 | Vérification unicité numéro contrat | Génération automatique | Numéro unique (ex: ASS-2025-00001) | Critique |

### 4.2 Consultation d'Assurances

| Test ID | Scénario | Résultat Attendu | Priorité |
|---------|----------|-------------------|----------|
| ASS-06 | Affichage liste complète | Liste paginée avec statuts visuels (badges colorés) | Critique |
| ASS-07 | Filtre par type | Sélection: Auto | Affichage assurances auto uniquement | Haute |
| ASS-08 | Filtre par statut | Sélection: Active | Affichage contrats actifs uniquement | Haute |
| ASS-09 | Filtre par succursale | Sélection: Yaoundé | Affichage contrats gérés par Yaoundé | Haute |
| ASS-10 | Recherche par numéro contrat | Saisie: ASS-2025-00001 | Affichage contrat correspondant | Moyenne |
| ASS-11 | Affichage détails assurance | Clic sur une assurance | Fiche détaillée avec infos client | Haute |

### 4.3 Modification d'Assurance

| Test ID | Scénario | Données de Test | Résultat Attendu | Priorité |
|---------|----------|-----------------|-------------------|----------|
| ASS-12 | Modification montant prime | Prime: 200000 | Assurance mise à jour | Critique |
| ASS-13 | Changement de statut | Statut: Résiliée | Statut mis à jour, badge rouge affiché | Haute |
| ASS-14 | Modification avec dates invalides | Dates incohérentes | Message d'erreur validation | Haute |
| ASS-15 | Modification du numéro contrat | Tentative de modification | Champ en lecture seule (non modifiable) | Moyenne |

### 4.4 Suppression d'Assurance

| Test ID | Scénario | Résultat Attendu | Priorité |
|---------|----------|-------------------|----------|
| ASS-16 | Suppression assurance | Modale de confirmation | Critique |
| ASS-17 | Confirmation suppression | Clic "Confirmer" | Assurance supprimée, message de succès | Critique |
| ASS-18 | Vérification cascade | Après suppression | Client toujours présent (pas de cascade) | Haute |

---

## 5. TESTS DASHBOARD

| Test ID | Scénario | Résultat Attendu | Priorité |
|---------|----------|-------------------|----------|
| DASH-01 | Affichage statistiques globales | Cartes: Nombre clients, contrats actifs, revenus | Critique |
| DASH-02 | Répartition par succursale | Graphiques ou tableaux Douala/Yaoundé | Haute |
| DASH-03 | Actualisation données temps réel | Ajout client → mise à jour compteur | Haute |
| DASH-04 | Graphiques interactifs | Survol graphiques | Affichage valeurs détaillées | Moyenne |

---

## 6. TESTS DE SÉCURITÉ

### 6.1 Injection SQL

| Test ID | Scénario | Données de Test | Résultat Attendu | Priorité |
|---------|----------|-----------------|-------------------|----------|
| SEC-01 | Injection formulaire client | Nom: ' OR '1'='1 | Données échappées, pas d'exécution SQL | Critique |
| SEC-02 | Injection recherche | Recherche: '; DROP TABLE clients; -- | Requête sécurisée, pas de suppression | Critique |
| SEC-03 | Injection URL | URL: ?id=1' OR '1'='1 | Paramètre sécurisé, erreur ou résultat vide | Critique |

### 6.2 XSS (Cross-Site Scripting)

| Test ID | Scénario | Données de Test | Résultat Attendu | Priorité |
|---------|----------|-----------------|-------------------|----------|
| SEC-04 | XSS formulaire | Nom: <script>alert('XSS')</script> | Caractères échappés, pas d'exécution script | Critique |
| SEC-05 | XSS affichage | Affichage nom avec script | Script non exécuté, texte affiché brut | Critique |

### 6.3 CSRF (Cross-Site Request Forgery)

| Test ID | Scénario | Résultat Attendu | Priorité |
|---------|----------|-------------------|----------|
| SEC-06 | Soumission formulaire sans token CSRF | Requête rejetée avec erreur | Critique |
| SEC-07 | Soumission avec token invalide | Requête rejetée avec erreur | Critique |

### 6.4 Contrôle d'Accès

| Test ID | Scénario | Résultat Attendu | Priorité |
|---------|----------|-------------------|----------|
| SEC-08 | Accès page admin sans connexion | Redirection vers login | Critique |
| SEC-09 | Accès fonctionnalité non autorisée | Message "Accès refusé" ou redirection | Critique |
| SEC-10 | Manipulation URL pour accéder autre utilisateur | Accès bloqué si non autorisé | Haute |

---

## 7. TESTS D'INTERFACE (UI/UX)

### 7.1 Responsive Design

| Test ID | Scénario | Appareil | Résultat Attendu | Priorité |
|---------|----------|----------|-------------------|----------|
| UI-01 | Affichage desktop | 1920x1080 | Layout complet, tableaux lisibles | Critique |
| UI-02 | Affichage tablette | 768px | Menu adapté, tableaux scrollables | Haute |
| UI-03 | Affichage mobile | 375px | Menu hamburger, cartes empilées | Haute |

### 7.2 Navigation

| Test ID | Scénario | Résultat Attendu | Priorité |
|---------|----------|-------------------|----------|
| UI-04 | Navigation menu principal | Liens fonctionnels vers toutes sections | Critique |
| UI-05 | Fil d'Ariane (breadcrumb) | Affichage chemin de navigation | Moyenne |
| UI-06 | Retour arrière navigateur | Fonctionnement correct, pas de perte données | Haute |

### 7.3 Formulaires

| Test ID | Scénario | Résultat Attendu | Priorité |
|---------|----------|-------------------|----------|
| UI-07 | Validation en temps réel | Messages d'erreur sous champs concernés | Haute |
| UI-08 | Boutons désactivés pendant soumission | Prévention double-clic, loader affiché | Haute |
| UI-09 | Autocomplete champs | Suggestions pertinentes (ex: villes) | Moyenne |

---

## 8. TESTS DE PERFORMANCE

| Test ID | Scénario | Critère de Réussite | Priorité |
|---------|----------|---------------------|----------|
| PERF-01 | Chargement page d'accueil | < 2 secondes | Haute |
| PERF-02 | Affichage liste 1000 clients | < 3 secondes avec pagination | Haute |
| PERF-03 | Recherche dans base | < 1 seconde | Moyenne |
| PERF-04 | Soumission formulaire | < 1 seconde | Moyenne |
| PERF-05 | Charge simultanée (20 utilisateurs) | Pas de ralentissement significatif | Moyenne |

---

## 9. PROCÉDURE D'EXÉCUTION

### 9.1 Préparation
1. Créer une base de données de test avec jeu de données
2. Préparer comptes utilisateurs de test (admin, gestionnaires)
3. Documenter la configuration de l'environnement

### 9.2 Exécution
1. Tester dans l'ordre: Authentification → Clients → Assurances → Dashboard
2. Exécuter tests critiques en priorité
3. Documenter chaque résultat (Réussi/Échoué/Bloqué)
4. Capturer captures d'écran pour anomalies

### 9.3 Rapports d'Anomalies

**Format de rapport de bug:**
- **ID**: BUG-001
- **Titre**: Description concise
- **Sévérité**: Critique / Haute / Moyenne / Basse
- **Étapes de reproduction**: 1, 2, 3...
- **Résultat observé**: Ce qui se passe
- **Résultat attendu**: Ce qui devrait se passer
- **Capture d'écran**: Si applicable
- **Environnement**: Navigateur, OS

### 9.4 Critères de Validation
- **Tests critiques**: 100% réussis
- **Tests haute priorité**: 95% réussis
- **Tests moyenne/basse priorité**: 85% réussis
- **Aucun bug bloquant** en production

---

## 10. MATRICE DE TRAÇABILITÉ

| Module | Tests Critiques | Tests Haute | Tests Moyenne/Basse | Total |
|--------|-----------------|-------------|---------------------|-------|
| Authentification | 4 | 2 | 2 | 8 |
| Gestion Clients | 8 | 5 | 10 | 23 |
| Gestion Assurances | 8 | 6 | 4 | 18 |
| Dashboard | 1 | 2 | 1 | 4 |
| Sécurité | 9 | 1 | 0 | 10 |
| Interface UI/UX | 3 | 5 | 2 | 10 |
| Performance | 0 | 3 | 2 | 5 |
| **TOTAL** | **33** | **24** | **21** | **78** |

---

## 11. PLANNING DES TESTS

| Phase | Durée Estimée | Responsable |
|-------|---------------|-------------|
| Préparation environnement | 1 jour | Développeur |
| Tests fonctionnels | 3 jours | Testeur |
| Tests de sécurité | 2 jours | Développeur + Testeur |
| Tests UI/Performance | 1 jour | Testeur |
| Correction bugs | 2-3 jours | Développeur |
| Tests de régression | 1 jour | Testeur |
| **TOTAL** | **10-11 jours** | - |

---

## 12. LIVRABLES

- Rapport de tests complet (Excel/PDF)
- Liste des bugs identifiés avec statuts
- Captures d'écran des anomalies
- Recommandations d'amélioration
- Certificat de validation (si succès)