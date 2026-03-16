# Learning Symfony (Teaching Project)

This repository is a learning and practice project for Symfony 8.

## Project Purpose

This codebase is intentionally focused on learning Symfony fundamentals, such as:

- Routing and Controllers
- Services and Dependency Injection
- Twig templates
- Doctrine ORM basics

It is **not** intended for direct production deployment.

## Current Stack

- PHP >= 8.4
- Symfony 8
- Doctrine ORM + Migrations
- Twig
- Docker Compose (PostgreSQL service)

## Run Locally

### 1. Install dependencies

```bash
composer install
```

### 2. Start database with Docker Compose (optional)

```bash
docker compose up -d database
```

### 3. Run Symfony local server

```bash
symfony server:start
```

Or use PHP built-in server if needed.
```
php -S localhost:8000 -t public
```

## Database

Default config in `.env` uses SQLite:

- `DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"`

If you want to use PostgreSQL via Docker, update `DATABASE_URL` accordingly.

## Security Note

This project is for learning purposes. Some routes and settings are intentionally simple and may not include full production-grade protections (for example: complete auth/access control, strict CSRF strategy for all state-changing endpoints, hardened secret management).

If you plan to evolve this into a real application, perform a dedicated security hardening pass before deployment.

## License

For personal learning and demo usage.
