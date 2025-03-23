# Chronia - Migration to Symfony Guide

This guide explains how to migrate the Chronia application from its current PHP implementation to a modern Symfony-based application.

## Migration Overview

The migration process transforms the traditional PHP application into a Symfony application, keeping all existing functionality while improving code structure, maintainability, and security.

## Key Benefits of Migration

1. **Modern Architecture**: Utilize Symfony's MVC architecture for better code organization
2. **Improved Security**: Benefit from Symfony's security features (CSRF protection, authentication)
3. **Better Dependency Management**: Use Composer for package management
4. **Environment Configuration**: Easily manage development vs production environments
5. **Command Line Tools**: Powerful CLI commands with Symfony Console
6. **Form Management**: Robust form handling and validation
7. **Templating System**: Switch from PHP templates to Twig templates
8. **Dependency Injection**: Service-based architecture with automatic dependency injection
9. **Testing**: Better support for unit and functional testing

## Migration Steps

### 1. Create a New Symfony Project

```bash
composer create-project symfony/skeleton chronia-symfony
cd chronia-symfony
composer require webapp
```

### 2. Set Up Directory Structure

- Copy the provided files to their respective locations in the new Symfony project
- Ensure the directory structure follows Symfony standards (see `symfony-structure.md`)

### 3. Configure Environment Variables

- Create `.env` and `.env.local` files with appropriate configuration
- Configure parameters in `config/services.yaml`

### 4. Update Code Based on Symfony Standards

All PHP classes need to be adapted to follow Symfony conventions:

- Namespace everything according to the Symfony structure
- Use dependency injection instead of direct instantiation
- Use Symfony services pattern for functionality

### 5. Convert Templates to Twig

Convert all PHP templates to Twig templates:

- Replace PHP syntax with Twig syntax
- Use Twig inheritance (extends, blocks)
- Use Twig functions for paths, assets, etc.

### 6. Implement Forms

Create Symfony form types for all form interactions:

- Use form validation
- Implement CSRF protection
- Handle form submissions properly

### 7. Implement Command Line Tools

Create Symfony console commands for CLI operations:

- List cron jobs
- Add new jobs
- Delete jobs
- Test jobs

### 8. Configure Security

Set up proper security:

- Create a minimal login system (if needed)
- Implement proper permission checks

### 9. Migrate Data

Create a script to migrate existing crontab entries to the new system.

### 10. Test Thoroughly

Test all functionality in both development and production environments.

## File Mapping from Old to New

| Original File | Symfony Equivalent |
|---------------|-------------------|
| `class/Controller.php` | `src/Controller/CronJobController.php` and `src/Controller/DashboardController.php` |
| `class/CrontabManager.php` | `src/Service/CrontabManager/ProdCrontabManager.php` |
| `class/DevCrontabManager.php` | `src/Service/CrontabManager/DevCrontabManager.php` |
| `class/Platform/*.php` | `src/Service/Platform/*.php` |
| `class/View.php` | Replaced by Twig templates |
| `view/*.php` | `templates/*.html.twig` |
| `public/*.php` | `public/index.php` (Symfony entry point) |
| `cli/chrona.sh` | `src/Command/*.php` |
| `config/*.json` | `.env`, `.env.local`, and `config/services.yaml` |

## Installation Instructions

1. Back up your existing Chronia installation
2. Run the provided install script (`install.sh`) as root
3. Configure your web server to point to the Symfony public directory
4. Access the application through your browser

## Development Workflow

For development:

1. Clone the repository
2. Run `composer install`
3. Create `.env.local` with development settings
4. Run `symfony server:start`

For more detailed instructions, see the `README.md` file in the new project.