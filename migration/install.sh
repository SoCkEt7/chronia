#!/bin/bash

# Chronia Symfony Installer
# This script will set up the Chronia application with Symfony

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[0;33m'
NC='\033[0m' # No Color

# Check if script is run as root
if [ "$EUID" -ne 0 ]; then
  echo -e "${RED}Please run as root${NC}"
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

echo -e "${GREEN}=== Installing $APP_NAME ===${NC}"

# Check if PHP is installed
if ! command -v php &> /dev/null; then
    echo -e "${RED}PHP is not installed. Please install PHP 8.0 or higher.${NC}"
    exit 1
fi

# Check for Composer
if ! command -v composer &> /dev/null; then
    echo -e "${YELLOW}Composer not found. Installing Composer...${NC}"
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
fi

# Create user if it doesn't exist
if ! id -u "$USER" &>/dev/null; then
    echo -e "${YELLOW}Creating $USER user...${NC}"
    useradd -m -s /bin/bash "$USER"
fi

# Create directories
echo -e "${YELLOW}Creating directories...${NC}"
mkdir -p "$INSTALL_DIR"
mkdir -p "$DATA_DIR"
mkdir -p "$LOG_DIR"

# Copy files from current directory to install dir
echo -e "${YELLOW}Copying application files...${NC}"
cp -r ./* "$INSTALL_DIR/"

# Set environment to production
echo -e "${YELLOW}Setting up environment...${NC}"
cd "$INSTALL_DIR"
composer install --no-dev --optimize-autoloader

# Set up environment variables
cat > "$INSTALL_DIR"/.env.local << EOF
APP_ENV=$PROD_ENV
APP_SECRET=$(openssl rand -hex 16)
CRONTAB_USER=$USER
DATA_PATH=$DATA_DIR
LOG_PATH=$LOG_DIR
EOF

# Create job runner script
echo -e "${YELLOW}Creating job runner script...${NC}"
cat > "$RUNNER_SCRIPT" << 'EOF'
#!/bin/bash

# Chronia Job Runner
# This script runs cron jobs and logs their output

JOB_COMMAND="$*"
LOG_DIR="/var/lib/chrona/logs"
LOG_FILE="$LOG_DIR/job_$(date +%Y%m%d_%H%M%S)_$$.log"

# Create log directory if it doesn't exist
mkdir -p "$LOG_DIR"

# Log start time and command
echo "JOB_START: $(date +'%Y-%m-%d %H:%M:%S')" > "$LOG_FILE"
echo "COMMAND: $JOB_COMMAND" >> "$LOG_FILE"
echo "----------" >> "$LOG_FILE"

# Run the command and capture output
(eval "$JOB_COMMAND" 2>&1) >> "$LOG_FILE"
EXIT_CODE=$?

# Log end time and exit code
echo "----------" >> "$LOG_FILE"
echo "JOB_END: $(date +'%Y-%m-%d %H:%M:%S')" >> "$LOG_FILE"
echo "EXIT_CODE: $EXIT_CODE" >> "$LOG_FILE"

# Return the same exit code
exit $EXIT_CODE
EOF

chmod +x "$RUNNER_SCRIPT"

# Set up sudo access for the web server to run commands as the chrona user
echo -e "${YELLOW}Setting up sudo access...${NC}"
cat > /etc/sudoers.d/chronia << EOF
# Allow web server to run specific commands as chrona user
www-data ALL=(chrona) NOPASSWD: /bin/systemctl status cron.service
www-data ALL=(chrona) NOPASSWD: /bin/systemctl restart cron.service
www-data ALL=(chrona) NOPASSWD: /usr/bin/crontab
www-data ALL=(chrona) NOPASSWD: $RUNNER_SCRIPT
EOF

chmod 0440 /etc/sudoers.d/chronia

# Set correct permissions
echo -e "${YELLOW}Setting permissions...${NC}"
chown -R $USER:$GROUP "$DATA_DIR"
chown -R $USER:$GROUP "$LOG_DIR"
chown -R www-data:www-data "$INSTALL_DIR/var"
chmod -R 755 "$INSTALL_DIR"
chmod -R 775 "$INSTALL_DIR/var"
chmod -R 775 "$DATA_DIR"
chmod -R 775 "$LOG_DIR"

# Build assets
echo -e "${YELLOW}Building assets...${NC}"
cd "$INSTALL_DIR"
php bin/console assets:install public

# Clear cache and warm up
echo -e "${YELLOW}Warming up cache...${NC}"
php bin/console cache:clear --env=prod
php bin/console cache:warmup --env=prod

echo -e "${GREEN}Installation completed!${NC}"
echo -e "${YELLOW}Please set up a web server to point to $INSTALL_DIR/public directory${NC}"
echo -e "${YELLOW}For example with Apache:${NC}"
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