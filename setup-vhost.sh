#!/bin/bash

# Script pour configurer un VirtualHost Apache pour Chronia

# Couleurs
GREEN='\033[0;32m'
YELLOW='\033[0;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Chemins
CURRENT_DIR=$(realpath $(dirname $0))
VHOST_CONF="$CURRENT_DIR/apache-vhost.conf"
VHOST_DEST="/etc/apache2/sites-available/cron-local.conf"

echo -e "${GREEN}=== Configuration du VirtualHost Apache pour Chronia ===${NC}"

# Vérifier les droits sudo
if [ "$EUID" -ne 0 ]; then
  echo -e "${YELLOW}Ce script nécessite des droits sudo pour configurer Apache.${NC}"
  echo -e "${YELLOW}Exécution avec sudo...${NC}"
  sudo "$0" "$@"
  exit $?
fi

# 1. Copier le fichier de configuration
echo -e "${YELLOW}Copie du fichier de configuration VirtualHost...${NC}"
cp "$VHOST_CONF" "$VHOST_DEST"

# 2. Ajuster les chemins dans le fichier de configuration
echo -e "${YELLOW}Ajustement des chemins dans le fichier de configuration...${NC}"
sed -i "s|/home/antonin/app/otherProjects/chronia/new-symfony|$CURRENT_DIR|g" "$VHOST_DEST"

# 3. Activer le site
echo -e "${YELLOW}Activation du VirtualHost...${NC}"
a2ensite cron-local.conf

# 4. Vérifier la configuration Apache
echo -e "${YELLOW}Vérification de la configuration Apache...${NC}"
apache2ctl configtest

if [ $? -ne 0 ]; then
    echo -e "${RED}La configuration Apache contient des erreurs. Veuillez les corriger avant de continuer.${NC}"
    exit 1
fi

# 5. Ajouter l'entrée dans le fichier hosts si nécessaire
HOST_ENTRY="127.0.0.1 cron.local"
if ! grep -q "$HOST_ENTRY" /etc/hosts; then
    echo -e "${YELLOW}Ajout de l'entrée cron.local dans /etc/hosts...${NC}"
    echo "$HOST_ENTRY" >> /etc/hosts
fi

# 6. Redémarrer Apache
echo -e "${YELLOW}Redémarrage d'Apache...${NC}"
systemctl restart apache2

if [ $? -eq 0 ]; then
    echo -e "${GREEN}Configuration réussie !${NC}"
    echo -e "${GREEN}Vous pouvez maintenant accéder à Chronia via : http://cron.local${NC}"
else
    echo -e "${RED}Échec du redémarrage d'Apache.${NC}"
    exit 1
fi

exit 0