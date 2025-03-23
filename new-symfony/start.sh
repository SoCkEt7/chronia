#!/bin/bash

# Chronia Symfony - Script de démarrage
# Ce script prépare l'environnement et lance le serveur Symfony

# Couleurs
GREEN='\033[0;32m'
YELLOW='\033[0;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

echo -e "${GREEN}=== Préparation de Chronia (Symfony) ===${NC}"

# Vérifier si Composer est installé
if ! command -v composer &> /dev/null; then
    echo -e "${YELLOW}Composer n'est pas installé. Veuillez l'installer avant de continuer.${NC}"
    exit 1
fi

# Vérifier si la CLI Symfony est installée
if ! command -v symfony &> /dev/null; then
    echo -e "${YELLOW}La CLI Symfony n'est pas installée. Utilisation du serveur PHP intégré.${NC}"
    echo -e "${YELLOW}Pour une meilleure expérience, installez la CLI Symfony : ${NC}https://symfony.com/download"
    SYMFONY_CLI_AVAILABLE=false
else
    SYMFONY_CLI_AVAILABLE=true
fi

# Créer les répertoires nécessaires s'ils n'existent pas
echo -e "${YELLOW}Création des répertoires...${NC}"
mkdir -p var/data var/log/jobs var/tmp var/cache

# Installer les dépendances si nécessaire
if [ ! -d "vendor" ] || [ ! -f "vendor/autoload.php" ]; then
    echo -e "${YELLOW}Installation des dépendances...${NC}"
    composer install
fi

# Nettoyer le cache
echo -e "${YELLOW}Nettoyage du cache...${NC}"
php bin/console cache:clear

# Précharger le cache
echo -e "${YELLOW}Préchargement du cache...${NC}"
php bin/console cache:warmup

# Vérifier l'existence du fichier crontab.txt pour le mode dev
if [ ! -f "var/data/crontab.txt" ]; then
    echo -e "${YELLOW}Création du fichier crontab.txt de développement...${NC}"
    mkdir -p var/data
    cat > var/data/crontab.txt << EOF
# Sample crontab for development
0 * * * * /usr/bin/php -f /path/to/script.php
0 0 * * * /usr/bin/backup.sh
*/5 * * * * /usr/bin/monitor.sh
EOF
fi

# Créer les fichiers de log d'exemple si nécessaire
if [ ! -d "var/log/jobs" ] || [ -z "$(ls -A var/log/jobs)" ]; then
    echo -e "${YELLOW}Création des fichiers de log d'exemple...${NC}"
    mkdir -p var/log/jobs
    NOW=$(date +'%Y-%m-%d %H:%M:%S')
    
    cat > var/log/jobs/job_sample_success.log << EOF
JOB_START: $NOW
COMMAND: /usr/bin/backup.sh
----------
Backup completed successfully.
----------
JOB_END: $NOW
EXIT_CODE: 0
EOF

    cat > var/log/jobs/job_sample_failure.log << EOF
JOB_START: $NOW
COMMAND: /usr/bin/failed-script.sh
----------
Error: File not found
----------
JOB_END: $NOW
EXIT_CODE: 1
EOF
fi

# Vérifier l'existence du fichier .env.local
if [ ! -f ".env.local" ]; then
    echo -e "${YELLOW}Création du fichier .env.local de développement...${NC}"
    cat > .env.local << EOF
# Development Configuration
APP_ENV=dev
CRONTAB_USER=$USER
DATA_PATH=./var/data
LOG_PATH=./var/data/logs
EOF
fi

# Vérifier si le VirtualHost est configuré
if [ -f "/etc/apache2/sites-enabled/cron-local.conf" ]; then
    VHOST_CONFIGURED=true
    echo -e "${GREEN}VirtualHost Apache déjà configuré.${NC}"
    echo -e "${GREEN}L'application est accessible via: http://cron.local${NC}"
else
    VHOST_CONFIGURED=false
    echo -e "${YELLOW}VirtualHost Apache non configuré.${NC}"
    echo -e "${YELLOW}Pour configurer le VirtualHost Apache, exécutez: sudo ./setup-vhost.sh${NC}"
    
    # Créer l'entrée hosts si nécessaire
    HOST_ENTRY="127.0.0.1 cron.local"
    if ! grep -q "$HOST_ENTRY" /etc/hosts; then
        echo -e "${YELLOW}Ajout de l'entrée cron.local dans /etc/hosts (nécessite peut-être sudo)...${NC}"
        echo "sudo sh -c \"echo '$HOST_ENTRY' >> /etc/hosts\""
        sudo sh -c "echo '$HOST_ENTRY' >> /etc/hosts" || echo -e "${YELLOW}Impossible d'ajouter l'entrée hosts. Vous devrez peut-être l'ajouter manuellement.${NC}"
    fi
fi

# Démarrer le serveur en fonction de la configuration
if [ "$VHOST_CONFIGURED" = true ]; then
    echo -e "${YELLOW}Utilisation du VirtualHost Apache. Aucun serveur de développement ne sera démarré.${NC}"
    echo -e "${YELLOW}Assurez-vous qu'Apache est en cours d'exécution.${NC}"
else
    # Utiliser le serveur Symfony avec le domaine cron.local sans port spécifique
    if [ "$SYMFONY_CLI_AVAILABLE" = true ]; then
        echo -e "${GREEN}Démarrage du serveur Symfony...${NC}"
        echo -e "${BLUE}L'application sera accessible à l'adresse: http://cron.local${NC}"
        echo -e "${YELLOW}Pour arrêter le serveur, exécutez: symfony server:stop${NC}"
        symfony server:start --daemon --port=80 --no-tls --passthru=app_dev.php || {
            echo -e "${RED}Impossible de démarrer le serveur Symfony sur le port 80 (nécessite des privilèges root).${NC}"
            echo -e "${YELLOW}Utilisation du port 8080 à la place...${NC}"
            symfony server:start --daemon --port=8080 --no-tls --passthru=app_dev.php
            echo -e "${BLUE}L'application sera accessible à l'adresse: http://cron.local:8080${NC}"
        }
    else
        echo -e "${GREEN}Démarrage du serveur PHP...${NC}"
        echo -e "${BLUE}L'application sera accessible à l'adresse: http://cron.local:8080${NC}"
        mkdir -p var
        nohup php -S cron.local:8080 -t public > var/server.log 2>&1 &
        echo $! > var/server.pid
        echo -e "${YELLOW}Pour arrêter le serveur, exécutez: ./stop.sh${NC}"
    fi
fi

exit 0