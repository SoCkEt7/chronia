# Chronia - Symfony Edition

Chronia is a web-based interface for managing crontab entries. This application allows non-technical users to easily schedule, edit, and monitor cron jobs on Linux systems.

## Features

- Display a dashboard with overview of all cron jobs
- List all configured cron jobs with status
- Add new cron jobs with easy scheduling options
- Edit existing cron jobs
- Enable/disable cron jobs
- Test run cron jobs to verify functionality
- View job execution history
- RESTful API for integration with other systems
- CLI commands for managing cron jobs from terminal
- Development mode for testing without root access

## Requirements

- PHP 8.0 or higher
- Symfony 6.0 or higher
- Linux system with crontab
- Sudo access for production mode
- Composer

## Installation

### Production Installation

1. Clone the repository
2. Run the install script as root:

```bash
sudo ./install.sh
```

This will:
- Create a chrona user
- Set up directories
- Configure sudo permissions
- Install dependencies
- Set up the job runner script
- Configure the application for production use

3. Configure your web server to point to the `public/` directory

### Development Installation

1. Clone the repository
2. Install dependencies:

```bash
composer install
```

3. Create a `.env.local` file with:

```
APP_ENV=dev
CRONTAB_USER=your_username
DATA_PATH=./var/data
LOG_PATH=./var/data/logs
```

4. Start the Symfony development server:

```bash
symfony server:start
```

## Usage

### Web Interface

Access the web interface at your configured URL. From there you can:

- View the dashboard
- List all cron jobs
- Add new cron jobs
- Edit existing cron jobs
- Test jobs
- Enable/disable jobs
- Delete jobs

### Command Line

The application provides several commands:

```bash
# List all cron jobs
php bin/console app:cron:list

# Add a new cron job
php bin/console app:cron:add "0 * * * *" "/path/to/script.sh"

# Test a cron job
php bin/console app:cron:test 1

# Delete a cron job
php bin/console app:cron:delete 1
```

## Development Notes

### Development Mode

The application can run in development mode, which:

1. Uses a file-based crontab instead of the system crontab
2. Simulates job execution instead of actually running commands
3. Provides sample data for testing

### Testing

Run tests with:

```bash
php bin/phpunit
```

## Architecture

- **Controllers**: Handle web requests and API calls
- **Services**: Core business logic
  - **CrontabManager**: Interface for managing crontab entries
    - **ProdCrontabManager**: Production implementation using sudo
    - **DevCrontabManager**: Development implementation using files
  - **Platform**: Platform-specific handlers
- **Commands**: CLI commands
- **Templates**: Twig templates for the UI

## License

This project is licensed under the MIT License - see the LICENSE file for details.