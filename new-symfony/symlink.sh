#!/bin/bash

# Script to create a symlink from the parent Chronia directory to the new-symfony directory

# Couleurs
GREEN='\033[0;32m'
YELLOW='\033[0;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

PARENT_DIR=$(dirname $(realpath $(dirname $0)))
CURRENT_DIR=$(realpath $(dirname $0))

echo -e "${GREEN}=== Configuration de Chronia ===${NC}"

if [ ! -d "$PARENT_DIR" ]; then
    echo -e "${RED}Répertoire parent introuvable: $PARENT_DIR${NC}"
    exit 1
fi

# Check if the symlink already exists
if [ -L "$PARENT_DIR/chronia" ]; then
    echo -e "${YELLOW}Le lien symbolique existe déjà. Suppression...${NC}"
    rm "$PARENT_DIR/chronia"
fi

# Create the symlink
echo -e "${YELLOW}Création du lien symbolique: $PARENT_DIR/chronia -> $CURRENT_DIR${NC}"
ln -s "$CURRENT_DIR" "$PARENT_DIR/chronia"

if [ $? -eq 0 ]; then
    echo -e "${GREEN}Lien symbolique créé avec succès.${NC}"
    echo -e "${YELLOW}Vous pouvez maintenant accéder à l'application via:${NC}"
    echo -e "${YELLOW}- Le répertoire: $PARENT_DIR/chronia${NC}"
    echo -e "${YELLOW}- L'URL: http://cron.local:8000${NC}"
else
    echo -e "${RED}Échec de la création du lien symbolique.${NC}"
    exit 1
fi

exit 0