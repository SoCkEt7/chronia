#!/bin/bash

# Chronia Symfony - Script d'arrêt
# Ce script arrête le serveur Chronia

# Couleurs
GREEN='\033[0;32m'
YELLOW='\033[0;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

echo -e "${GREEN}=== Arrêt de Chronia (Symfony) ===${NC}"

# Récupérer le port utilisé si disponible
if [ -f "var/server.port" ]; then
    PORT=$(cat var/server.port)
    echo -e "${YELLOW}Arrêt du serveur sur le port $PORT...${NC}"
else
    PORT="inconnu"
    echo -e "${YELLOW}Port du serveur inconnu, tentative d'arrêt...${NC}"
fi

# Vérifier si la CLI Symfony est installée
if command -v symfony &> /dev/null; then
    echo -e "${YELLOW}Arrêt du serveur Symfony...${NC}"
    symfony server:stop
    STOP_STATUS=$?
    
    if [ $STOP_STATUS -eq 0 ]; then
        echo -e "${GREEN}Serveur Symfony arrêté avec succès.${NC}"
    else
        echo -e "${RED}Échec de l'arrêt du serveur Symfony. Code: $STOP_STATUS${NC}"
    fi
elif [ -f "var/server.pid" ]; then
    echo -e "${YELLOW}Arrêt du serveur PHP...${NC}"
    PID=$(cat var/server.pid)
    
    if ps -p $PID > /dev/null; then
        kill $PID && echo -e "${GREEN}Serveur PHP arrêté (PID: $PID).${NC}" || echo -e "${RED}Échec de l'arrêt du serveur PHP.${NC}"
    else
        echo -e "${YELLOW}Le processus $PID n'est plus en cours d'exécution.${NC}"
    fi
    
    rm -f var/server.pid
    rm -f var/server.port
else
    echo -e "${YELLOW}Aucun serveur en cours d'exécution n'a été détecté.${NC}"
    
    # Tentative de recherche de processus PHP sur le port
    if [ "$PORT" != "inconnu" ]; then
        FOUND_PID=$(lsof -i :$PORT -t 2>/dev/null)
        if [ ! -z "$FOUND_PID" ]; then
            echo -e "${YELLOW}Processus trouvé sur le port $PORT (PID: $FOUND_PID). Tentative d'arrêt...${NC}"
            kill $FOUND_PID && echo -e "${GREEN}Processus arrêté.${NC}" || echo -e "${RED}Échec de l'arrêt du processus.${NC}"
        fi
    fi
fi

# Nettoyer les fichiers temporaires
rm -f var/server.pid var/server.port

echo -e "${GREEN}Nettoyage terminé.${NC}"
exit 0