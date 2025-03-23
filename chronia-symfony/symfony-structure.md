# Symfony Project Structure for Chronia

```
chronia-symfony/
├── bin/
│   └── console
├── config/
│   ├── packages/
│   │   ├── dev/
│   │   ├── prod/
│   │   └── framework.yaml
│   ├── routes.yaml
│   └── services.yaml
├── migrations/
├── public/
│   ├── css/
│   │   └── styles.css (migrated from original)
│   ├── js/
│   │   └── app.js (migrated from original)
│   ├── images/
│   │   ├── logo.svg (migrated from original)
│   │   └── codequantumio.svg (migrated from original)
│   └── index.php
├── src/
│   ├── Command/
│   │   ├── AddJobCommand.php
│   │   ├── ListJobsCommand.php
│   │   ├── RemoveJobCommand.php
│   │   └── TestJobCommand.php
│   ├── Controller/
│   │   ├── DashboardController.php
│   │   ├── CronJobController.php
│   │   └── ApiController.php
│   ├── Entity/
│   │   ├── CronJob.php
│   │   └── JobHistory.php
│   ├── Form/
│   │   └── CronJobType.php
│   ├── Repository/
│   │   ├── CronJobRepository.php
│   │   └── JobHistoryRepository.php
│   ├── Service/
│   │   ├── CrontabManager/
│   │   │   ├── CrontabManagerInterface.php
│   │   │   ├── ProdCrontabManager.php
│   │   │   └── DevCrontabManager.php
│   │   └── Platform/
│   │       ├── PlatformHandlerInterface.php
│   │       ├── StandardPlatformHandler.php
│   │       ├── DebianPlatformHandler.php
│   │       └── RedHatPlatformHandler.php
│   └── Kernel.php
├── templates/
│   ├── base.html.twig
│   ├── dashboard/
│   │   └── index.html.twig
│   ├── job/
│   │   ├── index.html.twig
│   │   ├── new.html.twig
│   │   ├── edit.html.twig
│   │   ├── show.html.twig
│   │   └── test.html.twig
│   └── security/
│       └── login.html.twig
├── tests/
├── var/
│   ├── cache/
│   └── log/
├── vendor/
├── .env
├── .env.local
├── .env.test
├── composer.json
└── symfony.lock
```

## Key Configuration Files

### .env
```
# Production Configuration
APP_ENV=prod
APP_SECRET=change_this_to_a_random_string
CRONTAB_USER=chrona
DATA_PATH=/var/lib/chrona
LOG_PATH=/var/lib/chrona/logs
```

### .env.local (for development)
```
# Development Configuration
APP_ENV=dev
CRONTAB_USER=your_dev_username
DATA_PATH=./var/data
LOG_PATH=./var/data/logs
```

### config/services.yaml
```yaml
parameters:
    crontab_user: '%env(CRONTAB_USER)%'
    data_path: '%env(DATA_PATH)%'
    log_path: '%env(LOG_PATH)%'
    sudo_allowed_commands:
        - '/bin/systemctl'
        - '/usr/bin/crontab'

services:
    # Default configuration for services
    _defaults:
        autowire: true
        autoconfigure: true
        public: false
        bind:
            $dataPath: '%data_path%'
            $logPath: '%log_path%'
            $crontabUser: '%crontab_user%'
            $allowedCommands: '%sudo_allowed_commands%'

    # Autowire classes from these namespaces
    App\:
        resource: '../src/'
        exclude:
            - '../src/Kernel.php'
            - '../src/Entity/'

    # Conditionally use dev/prod crontab manager
    App\Service\CrontabManager\CrontabManagerInterface:
        factory: '@App\Service\CrontabManagerFactory'
        arguments: ['%env(APP_ENV)%']
```