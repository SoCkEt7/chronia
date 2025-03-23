# Chronia - Gestionnaire de Tâches Cron

Chronia est une application web permettant de gérer facilement les tâches cron sur votre serveur. Basée sur Symfony 6.4, elle offre une interface utilisateur moderne pour visualiser, ajouter, modifier et tester vos tâches planifiées.

## Fonctionnalités

- Interface web intuitive pour gérer les entrées crontab
- Ajout et modification des tâches avec prévisualisation
- Test d'exécution des commandes en temps réel
- Activation/désactivation des tâches sans les supprimer
- Vue d'ensemble sur le tableau de bord
- Mode développement pour tester sans affecter le crontab système
- Compatible avec les environnements Debian, Red Hat et autres distributions Linux

## Prérequis

- PHP 8.1 ou supérieur
- Composer
- Serveur web (Apache, Nginx, etc.)
- Accès sudo pour certaines opérations (en mode production)

## Installation

### Mode Développement

1. Cloner le dépôt :
   ```
   git clone https://github.com/votre-utilisateur/chronia.git
   cd chronia
   ```

2. Installer les dépendances :
   ```
   composer install
   ```

3. Configurer l'environnement (si nécessaire) :
   ```
   cp .env .env.local
   ```

4. Démarrer le serveur de développement :
   ```
   symfony server:start
   # ou
   ./start.sh
   ```

5. Accéder à l'application :
   ```
   http://localhost:8000
   ```

### Mode Production

1. Cloner le dépôt sur votre serveur :
   ```
   git clone https://github.com/votre-utilisateur/chronia.git
   cd chronia
   ```

2. Exécuter le script d'installation (en tant que root) :
   ```
   sudo ./install.sh
   ```

3. Configurer votre serveur web pour pointer vers le répertoire `public/`

4. Accéder à l'application via votre navigateur

## Mise à jour depuis la version précédente

Si vous mettez à jour depuis une version précédente de Chronia, suivez ces étapes :

1. Faire une sauvegarde de vos données :
   ```
   cp -r var/data var/data_backup
   cp -r var/log var/log_backup
   ```

2. Mettre à jour le code :
   ```
   git pull
   ```

3. Installer les nouvelles dépendances :
   ```
   composer install
   ```

4. Vider le cache :
   ```
   php bin/console cache:clear
   ```

5. Vérifier les changements de configuration dans `.env.local`

## Structure du Projet

```
chronia/
├── bin/                      # Binaires Symfony
├── config/                   # Configuration
│   ├── packages/             # Configuration des packages
│   └── services.yaml         # Configuration des services
├── public/                   # Fichiers publics (point d'entrée web)
│   ├── css/                  # Feuilles de style CSS
│   ├── js/                   # Fichiers JavaScript
│   └── images/               # Images et logos
├── src/                      # Code source PHP
│   ├── Command/              # Commandes console
│   ├── Controller/           # Contrôleurs
│   ├── Form/                 # Types de formulaires
│   └── Service/              # Services
│       ├── CrontabManager/   # Gestionnaires de crontab
│       └── Platform/         # Gestionnaires de plateforme
├── templates/                # Templates Twig
│   ├── dashboard/            # Templates du tableau de bord
│   └── job/                  # Templates des tâches cron
├── var/                      # Données variables (cache, logs)
│   ├── data/                 # Données persistantes
│   └── log/                  # Journaux
└── vendor/                   # Dépendances (via Composer)
```

## Configuration

Les paramètres de configuration se trouvent dans les fichiers suivants :

- `.env.local` : Variables d'environnement
- `config/services.yaml` : Configuration des services
- `config/packages/` : Configuration des packages Symfony

### Variables d'Environnement

- `APP_ENV` : Environnement (dev, prod)
- `CRONTAB_USER` : Utilisateur crontab (par défaut : chrona)
- `DATA_PATH` : Chemin des données
- `LOG_PATH` : Chemin des journaux

## Utilisation

1. **Tableau de bord** : Vue d'ensemble des tâches et du système

2. **Liste des tâches** : Affiche toutes les tâches configurées
   - Voir le statut (actif/inactif)
   - Éditer, tester, activer/désactiver ou supprimer les tâches

3. **Ajouter une tâche** : Créer une nouvelle entrée crontab
   - Définir l'expression de planification
   - Spécifier la commande à exécuter

4. **Tester une tâche** : Exécuter une tâche sans attendre son déclenchement programmé

5. **Interface en ligne de commande** : Gérer les tâches via la console
   ```
   php bin/console app:cron:list   # Lister toutes les tâches cron
   ```

## Sécurité

En mode production, l'application utilise sudo pour certaines opérations. Les commandes autorisées sont strictement limitées pour garantir la sécurité du système.

## Licence

[MIT](LICENSE)

## Contact

Pour toute question ou suggestion, veuillez créer une issue sur le dépôt GitHub.