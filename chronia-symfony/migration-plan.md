# Chronia to Symfony Migration Plan

## Project Setup
1. Create a new Symfony project
2. Configure environment variables for development and production
3. Set up database if needed (we can use a simple entity for job history)

## Core Components Migration

### Entities
- `CronJob`: Represent a crontab entry with scheduling information
- `JobHistory`: Track execution history of jobs

### Controllers
- `DashboardController`: Main dashboard display
- `CronJobController`: CRUD operations for cron jobs
- `ApiController`: API endpoints for javascript functionality

### Services
- `CrontabManagerInterface`: Interface for crontab management
- `ProdCrontabManager`: Production implementation using sudo
- `DevCrontabManager`: Development implementation using files
- Platform specific handlers as services:
  - `PlatformHandlerInterface`
  - `StandardPlatformHandler`
  - `DebianPlatformHandler`
  - `RedHatPlatformHandler`

### Templates (Twig)
- `dashboard.html.twig`: Dashboard with overview
- `job/index.html.twig`: List all cron jobs
- `job/new.html.twig`: Create a new job
- `job/edit.html.twig`: Edit an existing job
- `job/show.html.twig`: Job details
- `job/test.html.twig`: Test results for a job

### Forms
- `CronJobType`: Form for creating/editing cron jobs

### Commands
- `ListJobsCommand`: List all cron jobs
- `AddJobCommand`: Add a new cron job
- `RemoveJobCommand`: Remove a cron job
- `TestJobCommand`: Test a cron job

### Security
- Simple admin authentication
- CSRF protection for forms

## Implementation Steps

1. Create the basic Symfony project with maker bundle
2. Set up environment configuration for dev/prod
3. Create entities and repositories
4. Implement services (start with dev version)
5. Create controllers and routes
6. Implement Twig templates using Bootstrap
7. Set up forms with validation
8. Implement CLI commands
9. Configure security
10. Test and refine implementation

## Data Migration
- Script to export existing crontab entries to the new format

## Deployment
- Update installation scripts for the Symfony project
- Create proper configuration for prod environment