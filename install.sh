#!/bin/bash

# Chronia Symfony Installer
# Ce script va installer l'application Chronia avec Symfony

# Couleurs
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[0;33m'
NC='\033[0m' # No Color

# Vérifier si le script est exécuté en tant que root
if [ "$EUID" -ne 0 ]; then
  echo -e "${RED}Veuillez exécuter ce script en tant que root${NC}"
  exit 1
fi

# Configuration
APP_NAME="Chronia"
USER="chrona"
GROUP="chrona"
INSTALL_DIR="/opt/chrona"
DATA_DIR="/var/lib/chrona"
LOG_DIR="/var/lib/chrona/logs"
RUNNER_SCRIPT="/usr/bin/chrona_job_runner.sh"
PROD_ENV="prod"

echo -e "${GREEN}=== Installation de $APP_NAME ===${NC}"

# Vérifier si PHP est installé
if ! command -v php &> /dev/null; then
    echo -e "${RED}PHP n'est pas installé. Veuillez installer PHP 8.0 ou supérieur.${NC}"
    exit 1
fi

# Vérifier Composer
if ! command -v composer &> /dev/null; then
    echo -e "${YELLOW}Composer non trouvé. Installation de Composer...${NC}"
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
fi

# Ask for crontab user
echo -e "${YELLOW}Quel utilisateur sera le principal gestionnaire de crontab ?${NC}"
read -p "Utilisateur (par défaut: $USER): " CRONTAB_USER
CRONTAB_USER=${CRONTAB_USER:-$USER}

# Créer l'utilisateur s'il n'existe pas
if ! id -u "$USER" &>/dev/null; then
    echo -e "${YELLOW}Création de l'utilisateur $USER...${NC}"
    useradd -m -s /bin/bash "$USER"
fi

# Créer les répertoires
echo -e "${YELLOW}Création des répertoires...${NC}"
mkdir -p "$INSTALL_DIR"
mkdir -p "$DATA_DIR"
mkdir -p "$LOG_DIR"

# Copier les fichiers du répertoire actuel vers le répertoire d'installation
echo -e "${YELLOW}Copie des fichiers de l'application...${NC}"
cp -r ./* "$INSTALL_DIR/"

# Configurer l'environnement de production
echo -e "${YELLOW}Configuration de l'environnement...${NC}"
cd "$INSTALL_DIR"
composer install --no-dev --optimize-autoloader

# Configurer les variables d'environnement
cat > "$INSTALL_DIR"/.env.local << EOF
APP_ENV=$PROD_ENV
APP_SECRET=$(openssl rand -hex 16)
DEFAULT_CRONTAB_USER=$CRONTAB_USER
DATA_PATH=$DATA_DIR
LOG_PATH=$LOG_DIR
EOF

# Créer le script d'exécution des tâches
echo -e "${YELLOW}Création du script d'exécution des tâches...${NC}"
cat > "$RUNNER_SCRIPT" << 'EOF'
#!/bin/bash

# Chronia Job Runner
# Ce script exécute les tâches cron et journalise leur sortie

JOB_COMMAND="$*"
LOG_DIR="/var/lib/chrona/logs"
LOG_FILE="$LOG_DIR/job_$(date +%Y%m%d_%H%M%S)_$$.log"

# Créer le répertoire de log s'il n'existe pas
mkdir -p "$LOG_DIR"

# Journaliser l'heure de début et la commande
echo "JOB_START: $(date +'%Y-%m-%d %H:%M:%S')" > "$LOG_FILE"
echo "COMMAND: $JOB_COMMAND" >> "$LOG_FILE"
echo "----------" >> "$LOG_FILE"

# Exécuter la commande et capturer la sortie
(eval "$JOB_COMMAND" 2>&1) >> "$LOG_FILE"
EXIT_CODE=$?

# Journaliser l'heure de fin et le code de sortie
echo "----------" >> "$LOG_FILE"
echo "JOB_END: $(date +'%Y-%m-%d %H:%M:%S')" >> "$LOG_FILE"
echo "EXIT_CODE: $EXIT_CODE" >> "$LOG_FILE"

# Retourner le même code de sortie
exit $EXIT_CODE
EOF

chmod +x "$RUNNER_SCRIPT"

# Configurer l'accès sudo pour que le serveur web puisse exécuter des commandes en tant qu'utilisateur chrona
echo -e "${YELLOW}Configuration de l'accès sudo...${NC}"
cat > /etc/sudoers.d/chronia << EOF
# Autoriser le serveur web à exécuter des commandes spécifiques en tant qu'utilisateur chrona
www-data ALL=($USER) NOPASSWD: /bin/systemctl status cron.service
www-data ALL=($USER) NOPASSWD: /bin/systemctl restart cron.service
www-data ALL=($USER) NOPASSWD: /usr/bin/crontab
www-data ALL=($USER) NOPASSWD: $RUNNER_SCRIPT
EOF

chmod 0440 /etc/sudoers.d/chronia

# Définir les permissions correctes
echo -e "${YELLOW}Configuration des permissions...${NC}"
chown -R $USER:$GROUP "$DATA_DIR"
chown -R $USER:$GROUP "$LOG_DIR"
chown -R www-data:www-data "$INSTALL_DIR/var"
chmod -R 755 "$INSTALL_DIR"
chmod -R 775 "$INSTALL_DIR/var"
chmod -R 775 "$DATA_DIR"
chmod -R 775 "$LOG_DIR"

# Compiler les assets
echo -e "${YELLOW}Compilation des assets...${NC}"
cd "$INSTALL_DIR"
php bin/console assets:install public

# Vider le cache et le préchauffer
echo -e "${YELLOW}Préchauffage du cache...${NC}"
php bin/console cache:clear --env=prod
php bin/console cache:warmup --env=prod

echo -e "${GREEN}Installation terminée !${NC}"
echo -e "${YELLOW}Veuillez configurer un serveur web pour pointer vers le répertoire $INSTALL_DIR/public${NC}"
echo -e "${YELLOW}Par exemple avec Apache :${NC}"
echo "
<VirtualHost *:80>
    ServerName chronia.local
    DocumentRoot $INSTALL_DIR/public
    
    <Directory $INSTALL_DIR/public>
        AllowOverride All
        Order Allow,Deny
        Allow from All
        Require all granted
        FallbackResource /index.php
    </Directory>
    
    ErrorLog \${APACHE_LOG_DIR}/chronia_error.log
    CustomLog \${APACHE_LOG_DIR}/chronia_access.log combined
</VirtualHost>
"

exit 0