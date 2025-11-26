# MÃTHODE DE SURVEILLANCE ET MAINTIEN DE DISPONIBILITÃ‰

## Approche Recommandée : **Monitoring Proactif Multi-Couches**

### 1. **Surveillance Automatisée Continue**

#### A. Monitoring de Disponibilité (Uptime)
```bash
# Installation d'un service de surveillance externe
# Exemple avec Uptime Robot (gratuit) ou équivalent
```

**Configuration :**
- Vérification HTTP/HTTPS toutes les 5 minutes
- Endpoints à surveiller :
  - Page de connexion : `https://votredomaine.com/login`
  - API santé : `https://votredomaine.com/health-check.php`
  - Base de données : endpoint de test connexion

**Alertes automatiques :**
- Email/SMS si site inaccessible > 2 minutes
- Notification Telegram/Slack pour l'équipe technique

#### B. Script de Santé Système
```bash
# Créer /var/www/html/intia/public/health-check.php
```

```php
<?php
// Vérifications essentielles
$checks = [
    'database' => test_db_connection(),
    'disk_space' => disk_free_space('/') > 1073741824, // >1GB
    'php_version' => version_compare(PHP_VERSION, '8.0.0', '>='),
    'writable_logs' => is_writable('/var/www/html/intia/logs')
];

http_response_code(all_passed($checks) ? 200 : 503);
echo json_encode($checks);
?>
```

### 2. **Surveillance des Ressources Serveur**

#### Script de Monitoring Local
```bash
# Créer /usr/local/bin/monitor_intia.sh
```

```bash
#!/bin/bash

# Seuils d'alerte
CPU_THRESHOLD=80
MEM_THRESHOLD=85
DISK_THRESHOLD=90

# Vérifications
cpu_usage=$(top -bn1 | grep "Cpu(s)" | awk '{print $2}' | cut -d'%' -f1)
mem_usage=$(free | grep Mem | awk '{print ($3/$2) * 100}')
disk_usage=$(df -h / | awk 'NR==2 {print $5}' | cut -d'%' -f1)

# Alertes si dépassement
if (( $(echo "$cpu_usage > $CPU_THRESHOLD" | bc -l) )); then
    echo "ALERTE: CPU à ${cpu_usage}%" | mail -s "INTIA: CPU élevé" admin@intia.cm
fi

# Redémarrage automatique services si nécessaire
if ! systemctl is-active --quiet apache2; then
    systemctl restart apache2
    echo "Apache redémarré automatiquement" | mail -s "INTIA: Redémarrage Apache" admin@intia.cm
fi
```

**Planification Cron :**
```bash
*/10 * * * * /usr/local/bin/monitor_intia.sh
```

### 3. **Système de Redémarrage Automatique**

#### Watchdog Apache/MySQL
```bash
# Installer monit
sudo apt install monit -y

# Configurer /etc/monit/conf.d/intia.conf
```

```
check process apache2 with pidfile /var/run/apache2/apache2.pid
    start program = "/usr/bin/systemctl start apache2"
    stop program = "/usr/bin/systemctl stop apache2"
    if failed host localhost port 80 protocol http then restart
    if 5 restarts within 5 cycles then alert

check process mysql with pidfile /var/run/mysqld/mysqld.pid
    start program = "/usr/bin/systemctl start mysql"
    stop program = "/usr/bin/systemctl stop mysql"
    if failed host localhost port 3306 then restart
    if 5 restarts within 5 cycles then alert
```

### 4. **Logs Centralisés et Analysés**

#### Rotation et Surveillance des Logs
```bash
# Configuration logrotate pour éviter saturation disque
# /etc/logrotate.d/intia
```

```
/var/www/html/intia/logs/*.log {
    daily
    rotate 14
    compress
    missingok
    notifempty
}
```

#### Analyse Automatique des Erreurs
```bash
# Script détection erreurs critiques
*/30 * * * * grep -i "fatal\|critical" /var/log/apache2/intia_error.log | tail -20 | mail -s "INTIA: Erreurs critiques" admin@intia.cm
```

### 5. **Plan de Reprise Après Incident (PRA)**

#### Checklist de Récupération Rapide
1. **Diagnostic** (2 min) : Consulter dashboard monitoring
2. **Redémarrage services** (1 min) : `systemctl restart apache2 mysql`
3. **Vérification logs** (3 min) : Identifier la cause
4. **Restauration BDD** (5-10 min) : Depuis dernière sauvegarde si corruption
5. **Notification** : Informer utilisateurs si temps d'arrêt > 10 min

### 6. **Dashboard de Surveillance Visuel**

#### Utilisation d'outils gratuits
- **Grafana + Prometheus** : Métriques temps réel
- **Netdata** : Monitoring système simple
- **Glances** : Vue terminal des ressources

```bash
# Installation Netdata (recommandé pour simplicité)
bash <(curl -Ss https://get.netdata.cloud/kickstart.sh)
# Accès : http://serveur:19999
```

### 7. **Tests de Disponibilité Réguliers**

#### Tests Automatisés Hebdomadaires
```bash
# Script de test fonctionnel
# /usr/local/bin/test_intia.sh
```

```bash
#!/bin/bash

# Test connexion
response=$(curl -s -o /dev/null -w "%{http_code}" https://votredomaine.com/login)
if [ $response -ne 200 ]; then
    echo "ERREUR: Site inaccessible (HTTP $response)" | mail -s "INTIA: Test échoué" admin@intia.cm
fi

# Test base de données
mysql -u intia_user -p'password' intia_assurance -e "SELECT 1" > /dev/null 2>&1
if [ $? -ne 0 ]; then
    echo "ERREUR: BDD inaccessible" | mail -s "INTIA: BDD KO" admin@intia.cm
fi
```

**Planification :**
```bash
0 2 * * 1 /usr/local/bin/test_intia.sh  # Tous les lundis 2h
```

---

## RÃ‰SUMÃ‰ - STACK DE SURVEILLANCE COMPLÃ¨TE

| Composant | Outil | Fréquence Vérification | Action Automatique |
|-----------|-------|------------------------|-------------------|
| Disponibilité externe | Uptime Robot | 5 minutes | Alerte email/SMS |
| Santé application | health-check.php | 5 minutes (via Uptime Robot) | - |
| Ressources serveur | Script monitor_intia.sh | 10 minutes | Redémarrage si nécessaire |
| Services critiques | Monit | Temps réel | Restart automatique |
| Logs erreurs | Grep + Cron | 30 minutes | Email si erreurs critiques |
| Sauvegardes | backup_intia.sh | Quotidien (2h) | Sauvegarde BDD + fichiers |
| Tests fonctionnels | test_intia.sh | Hebdomadaire | Alerte si échec |

**Temps de détection d'incident :** < 5 minutes  
**Temps de récupération automatique :** < 2 minutes  
**Temps d'intervention manuelle si nécessaire :** < 15 minutes