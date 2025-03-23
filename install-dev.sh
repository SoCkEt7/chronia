#!/bin/bash
# Development-focused installation for Chrona

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[0;33m'
CYAN='\033[0;36m'
NC='\033[0m' # No Color

echo -e "${GREEN}Chrona - Development Environment Setup${NC}\n"

# Create necessary directories
mkdir -p config public/css public/js

echo -e "${GREEN}Checking dependencies...${NC}"

# Check for PHP
if ! command -v php &> /dev/null; then
    echo -e "${YELLOW}PHP is not installed. Please install PHP 7.4 or later.${NC}"
    HAS_ERRORS=1
fi

# Check for Symfony CLI
if ! command -v symfony &> /dev/null; then
    echo -e "${YELLOW}Symfony CLI is not installed. Would you like to install it? (y/n)${NC}"
    read -r answer
    if [[ "$answer" =~ ^[Yy]$ ]]; then
        echo -e "${GREEN}Installing Symfony CLI...${NC}"
        curl -sS https://get.symfony.com/cli/installer | bash
        export PATH="$HOME/.symfony5/bin:$PATH"
    else
        echo -e "${YELLOW}Symfony CLI is recommended for development.${NC}"
        HAS_ERRORS=1
    fi
fi

# Create mock data directory for development
if [ ! -d "data" ]; then
    echo -e "${GREEN}Creating mock data directory...${NC}"
    mkdir -p data/logs
    
    # Create a sample crontab file for development
    echo -e "# Sample crontab entries for development\n0 * * * * /usr/bin/php -f /path/to/script.php\n0 0 * * * /usr/bin/backup.sh\n*/5 * * * * /usr/bin/monitor.sh" > data/crontab.txt
    
    # Create sample logs
    echo -e "JOB_START: $(date)\nCOMMAND: /usr/bin/backup.sh\n----------\nBackup completed successfully.\n----------\nJOB_END: $(date)\nEXIT_CODE: 0" > data/logs/job_sample_success.log
    echo -e "JOB_START: $(date)\nCOMMAND: /usr/bin/failed-script.sh\n----------\nError: File not found\n----------\nJOB_END: $(date)\nEXIT_CODE: 1" > data/logs/job_sample_failure.log
fi

# Ask for crontab user
echo -e "${YELLOW}Which user will be the primary crontab manager?${NC}"
read -p "User (default: $(whoami)): " CRONTAB_USER
CRONTAB_USER=${CRONTAB_USER:-$(whoami)}

# Create a development config
if [ ! -f "config/dev.json" ]; then
    echo -e "${GREEN}Creating development configuration...${NC}"
    cat > config/dev.json << EOL
{
    "dev_mode": true,
    "version": "1.0.0",
    "app_name": "Chrona",
    "cron_service": "cron.service",
    "data_path": "./data",
    "log_path": "./data/logs",
    "platform": "dev",
    "security": {
        "sudo_user": "${CRONTAB_USER}",
        "temp_dir": "/tmp",
        "job_runner": "./dev/job_runner.sh"
    },
    "ui": {
        "theme": "light",
        "show_help": true
    }
}
EOL
fi

# Create a simple development job runner
if [ ! -d "dev" ]; then
    echo -e "${GREEN}Creating development tools...${NC}"
    mkdir -p dev
    
    cat > dev/job_runner.sh << 'EOL'
#!/bin/bash
# Development job runner that simulates running cron jobs

if [ $# -eq 0 ]; then
    echo "Error: No command provided"
    exit 1
fi

echo "====== DEVELOPMENT MODE ======"
echo "Would execute: $@"
echo "=============================="

# Simulate success or failure randomly
if [ $((RANDOM % 10)) -gt 2 ]; then
    echo "Simulated successful execution"
    exit 0
else
    echo "Simulated failure for testing"
    exit 1
fi
EOL
    
    chmod +x dev/job_runner.sh
fi

# Create .env file for Symfony
if [ ! -f ".env" ]; then
    echo -e "${GREEN}Creating .env file...${NC}"
    cat > .env << EOL
# Development environment settings
APP_ENV=dev
APP_DEBUG=1
APP_SECRET=d3v3l0pm3nts3cr3tdonotuseinproduction
DEFAULT_CRONTAB_USER=${CRONTAB_USER}
EOL
fi

if [ -n "$HAS_ERRORS" ]; then
    echo -e "\n${YELLOW}Setup completed with warnings. Please address the issues above.${NC}"
else
    echo -e "\n${GREEN}Development environment setup complete!${NC}"
fi

echo -e "\nTo start the development server:"
echo -e "${CYAN}./start.sh${NC}"

echo -e "\nFor a better development experience, consider installing:"
echo -e "- PHP CS Fixer: ${CYAN}composer require --dev friendsofphp/php-cs-fixer${NC}"
echo -e "- PHPUnit: ${CYAN}composer require --dev phpunit/phpunit${NC}"