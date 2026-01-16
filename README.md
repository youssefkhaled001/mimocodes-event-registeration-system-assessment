# Mimocodes Event Registration System

A comprehensive event management and registration system built with Laravel 12, featuring a modern dark glassmorphism UI inspired by Mimocodes aesthetic.

## Table of Contents

-   [Features](#features)
-   [Requirements](#requirements)
-   [Installation](#installation)
-   [Database Configuration](#database-configuration)
-   [Admin Credentials](#admin-credentials)
-   [Running the Application](#running-the-application)
-   [Testing](#testing)
-   [Project Structure](#project-structure)

## Features

### Public Features

-   **Event Listing Page**: Browse all published events with a premium dark-themed UI
-   **Event Registration**:
    -   Dual registration flow for new and returning users
    -   Tabbed interface for seamless user experience
    -   Email-based quick registration for returning attendees
    -   Full registration form for new attendees
-   **Automatic Waitlist Management**: When events reach capacity, new registrations are automatically waitlisted
-   **Responsive Design**: Mobile-friendly interface with glassmorphism effects and cyan accent colors

### Admin Features

-   **Dashboard**:
    -   Event statistics (total, published, draft, completed)
    -   Registration status overview (confirmed, waitlisted, cancelled)
    -   Payment status tracking (paid, pending, refunded)
    -   Revenue trends visualization with interactive line charts
    -   Interactive doughnut charts for status distributions (powered by Bladewind/Chart.js)
-   **Event Management**:
    -   Create, edit, and delete events
    -   Set event capacity, pricing, and location
    -   Manage event status (draft, published, completed)
    -   View all events in a paginated table
-   **Registration Management**:
    -   View all registrations for specific events
    -   Update payment status (paid, pending, refunded)
    -   Cancel registrations with automatic waitlist promotion
    -   Filter and search registrations
-   **Profile Management**: Update admin profile and password

### Advanced Features

-   **Email Notifications**: Automated email system for attendee communication
    -   Registration confirmation emails (confirmed and waitlisted)
    -   Waitlist promotion notifications
    -   24-hour event reminder emails
    -   Queued email delivery for performance
-   **Automatic Waitlist Promotion**: When a confirmed registration is cancelled, the first waitlisted attendee is automatically promoted to confirmed status
-   **Scheduled Event Completion**: Events are automatically marked as completed 1 hour after their start time
-   **Queue System**: Background job processing for email notifications and heavy tasks
-   **Database Transactions**: Ensures data consistency during critical operations
-   **HEIC Image Support**: Upload and preview HEIC images with automatic conversion
-   **Custom Pagination**: Styled pagination matching the Mimocodes aesthetic
-   **Custom Scrollbar**: Global dark-themed scrollbar styling

## Requirements

-   PHP 8.2 or higher
-   Composer
-   Node.js 18+ and npm
-   PostgreSQL 13+ (or SQLite for development)
-   Laravel Herd (optional, for local development)

## Installation

### 1. Clone the Repository

```bash
git clone https://github.com/youssefkhaled001/mimocodes-event-registeration-system-assessment.git
cd mimocodes-event-registeration-system-assessment
```

### 2. Quick Setup (Recommended)

Run the automated setup script:

```bash
composer run setup
```

This will:

-   Install PHP dependencies
-   Copy `.env.example` to `.env`
-   Generate application key
-   Run database migrations
-   Install Node.js dependencies
-   Build frontend assets

### 3. Manual Setup (Alternative)

If you prefer manual setup:

```bash
# Install PHP dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Install Node.js dependencies
npm install

# Build frontend assets
npm run build
```

## Database Configuration

### Option 1: PostgreSQL (Recommended for Production)

1. Create a PostgreSQL database:

```sql
CREATE DATABASE mimocodes_event_registeration_system_assessment;
```

2. Update your `.env` file:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=mimocodes_event_registeration_system_assessment
DB_USERNAME=your_postgres_username
DB_PASSWORD=your_postgres_password
```

### Option 2: SQLite (Recommended for Development)

1. Update your `.env` file:

```env
DB_CONNECTION=sqlite
# Comment out or remove these lines:
# DB_HOST=127.0.0.1
# DB_PORT=5432
# DB_DATABASE=mimocodes_event_registeration_system_assessment
# DB_USERNAME=root
# DB_PASSWORD=
```

2. Create the SQLite database file:

```bash
touch database/database.sqlite
```

### Run Migrations

```bash
php artisan migrate
```

### Seed the Database (Optional)

To populate the database with sample data:

```bash
php artisan db:seed
```

This will create:

-   1 test user (admin)
-   300 sample events
-   700 sample attendees
-   3000 sample registrations

## Admin Credentials

After running the database seeder, you can log in with:

**Email**: `test@example.com`  
**Password**: `password`

> **Note**: If you haven't run the seeder, you'll need to register a new admin account through the registration flow.

## Running the Application

### Development Mode (All Services)

Run all development services (Laravel server, Vite, Queue worker, and Scheduler):

```bash
composer run dev
```

This starts:

-   **Laravel Server**: http://localhost:8000
-   **Vite Dev Server**: http://localhost:5173
-   **Queue Worker**: Processes background jobs
-   **Scheduler**: Runs scheduled tasks (e.g., auto-completing events)

### Individual Services

If you prefer to run services separately:

```bash
# Laravel development server
php artisan serve

# Vite development server (for hot module replacement)
npm run dev

# Queue worker (for background jobs)
php artisan queue:listen --tries=1

# Scheduler (for scheduled tasks)
php artisan schedule:work
```

### Production Build

```bash
# Build optimized assets
npm run build

# Optimize Laravel
php artisan optimize
```

## Testing

Run the test suite:

```bash
composer run test
```

Or run tests directly:

```bash
php artisan test
```

## Project Structure

```
├── app/
│   ├── Console/Commands/        # Custom Artisan commands
│   │   └── UpdateCompletedEvents.php
│   ├── Http/Controllers/        # Application controllers
│   │   ├── EventController.php
│   │   ├── RegisterationController.php
│   │   └── ProfileController.php
│   ├── Models/                  # Eloquent models
│   │   ├── Event.php
│   │   ├── Attendee.php
│   │   ├── Registeration.php
│   │   └── User.php
│   └── Observers/               # Model observers
│       └── RegisterationObserver.php
├── database/
│   ├── factories/               # Model factories
│   ├── migrations/              # Database migrations
│   └── seeders/                 # Database seeders
├── resources/
│   ├── css/                     # Stylesheets
│   ├── js/                      # JavaScript files
│   └── views/                   # Blade templates
│       ├── admin/               # Admin panel views
│       ├── components/          # Reusable components
│       └── layouts/             # Layout templates
├── routes/
│   ├── web.php                  # Web routes
│   └── auth.php                 # Authentication routes
└── public/                      # Public assets
```

## Design System

The application uses a custom design system with:

-   **Color Palette**: Dark theme with cyan accents (#06b6d4)
-   **Typography**: Playfair Display (headings) and Inter (body)
-   **Effects**: Glassmorphism, subtle shadows, and smooth animations
-   **Components**: Custom-styled forms, tables, buttons, and cards

## Key Workflows

### Event Lifecycle

1. **Draft** → Created but not visible to public
2. **Published** → Visible and accepting registrations
3. **Completed** → Auto-marked 1 hour after event start time

### Registration Lifecycle

1. **Confirmed** → Attendee has a guaranteed spot
2. **Waitlisted** → Event at capacity, waiting for cancellations
3. **Cancelled** → Registration cancelled (triggers waitlist promotion)

### Payment Status

-   **Pending** → Payment not yet received
-   **Paid** → Payment confirmed
-   **Refunded** → Payment returned to attendee

## Environment Variables

Key environment variables to configure:

```env
APP_NAME="Mimocodes Event Registration"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=pgsql
DB_DATABASE=mimocodes_event_registeration_system_assessment

# Queue
QUEUE_CONNECTION=database

# Cache
CACHE_STORE=database

# Session
SESSION_DRIVER=database

# Mail (for notifications)
MAIL_MAILER=log
```

## Troubleshooting

### Port Already in Use

If port 8000 is already in use, specify a different port:

```bash
php artisan serve --port=8080
```

### Database Connection Issues

-   Verify PostgreSQL is running: `pg_isready`
-   Check database credentials in `.env`
-   For SQLite, ensure `database/database.sqlite` exists

### Asset Build Errors

```bash
# Clear npm cache
npm cache clean --force

# Reinstall dependencies
rm -rf node_modules package-lock.json
npm install
```

### Queue Not Processing

Ensure the queue worker is running:

```bash
php artisan queue:listen
```

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Acknowledgments

-   Built with [Laravel 12](https://laravel.com)
-   UI components from [Bladewind](https://bladewindui.com)
-   Design inspired by [Mimocodes](https://mimocodes.com)
