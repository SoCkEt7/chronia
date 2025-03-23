# Guide de Migration de Chronia

Ce document explique comment la nouvelle version de Chronia a été installée à la racine du projet.

> Note: Les fichiers ont été copiés de `new-symfony/` vers la racine du projet, et le répertoire `new-symfony/` est maintenant obsolète.

## Avant de commencer

1. Sauvegardez vos données :
   ```bash
   cp -r /chemin/vers/votre/chronia/var/data /chemin/vers/sauvegarde/
   cp -r /chemin/vers/votre/chronia/var/log /chemin/vers/sauvegarde/
   ```

2. Notez votre configuration actuelle (utilisateurs, chemins personnalisés, etc.)

## Procédure de migration

### 1. Obtenir la nouvelle version

```bash
# Cloner le nouveau dépôt
git clone https://github.com/votre-utilisateur/chronia.git chronia-new
cd chronia-new

# OU si vous mettez à jour le dépôt existant
cd chronia
git pull
git checkout nouvelle-version
```

### 2. Configurer la nouvelle version

```bash
# Créer le fichier d'environnement
cp .env .env.local
```

Éditez le fichier `.env.local` pour définir vos chemins personnalisés si nécessaire :

```
APP_ENV=prod
DATA_PATH=/chemin/vers/vos/donnees
LOG_PATH=/chemin/vers/vos/logs
```

### 3. Installer les dépendances

```bash
composer install --no-dev --optimize-autoloader
```

### 4. Créer le lien symbolique pour faire de new-symfony le répertoire principal

```bash
./symlink.sh
```

### 5. Configuration du VirtualHost (recommandée)

Pour une installation optimale, configurez un VirtualHost Apache :

```bash
sudo ./setup-vhost.sh
```

Cela configurera automatiquement un VirtualHost Apache pour accéder à l'application via http://cron.local sans spécifier de port.

### 6. Démarrer l'application

Selon votre configuration :

```bash
# Si vous avez configuré le VirtualHost Apache
sudo systemctl restart apache2

# OU en mode développement sans VirtualHost
./start.sh
```

La nouvelle version sera accessible à l'adresse : http://cron.local

### 7. Utilisation de l'interface en ligne de commande

Pour exécuter des commandes Symfony :
```bash
# Lister les tâches cron
php bin/console app:cron:list
```

## Changements importants

1. **Utilisateur crontab** : La nouvelle version utilise toujours l'utilisateur courant pour les opérations crontab, ce qui simplifie la configuration.

2. **Domaine local** : L'application utilise maintenant le domaine `cron.local` au lieu de `localhost` pour un accès plus intuitif.

3. **Configurations de serveur** :
   - **VirtualHost Apache** : Mode recommandé pour une expérience optimale
   - **Serveur Symfony** : Alternative pratique en développement
   - **Serveur PHP intégré** : Option de secours

4. **Versions requises** :
   - PHP 8.1 ou supérieur (au lieu de PHP 8.0)
   - Symfony 6.4

## Options de déploiement

### Option 1 : VirtualHost Apache (recommandée)

Avantages :
- Pas de port spécifique à spécifier (utilise le port 80 standard)
- Performance optimale
- Configuration persistante

Configuration :
```bash
sudo ./setup-vhost.sh
```

### Option 2 : Serveur Symfony

Avantages :
- Facile à utiliser en développement
- Ne nécessite pas de configuration Apache
- Redémarrage automatique lors des modifications

Démarrage :
```bash
./start.sh
```

## Retour à l'ancienne version

Si vous rencontrez des problèmes avec la nouvelle version, vous pouvez toujours revenir à l'ancienne version en :

1. Désactivant le VirtualHost si configuré :
```bash
sudo a2dissite cron-local.conf
sudo systemctl restart apache2
```

2. Ou arrêtant le serveur de développement :
```bash
./stop.sh
```

3. Remettant en place votre ancienne installation.

## Problèmes connus

- Si vous rencontrez des problèmes d'accès avec le domaine `cron.local`, vérifiez que l'entrée a bien été ajoutée à votre fichier `/etc/hosts`
- Le démarrage du serveur Symfony sur le port 80 nécessite des privilèges root. Le script tentera automatiquement d'utiliser le port 8080 en cas d'échec.