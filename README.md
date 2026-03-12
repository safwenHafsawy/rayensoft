This repo is a Laravel 12 app dockerized with **Docker Compose**:

- `app` = PHP-FPM (PHP 8.3 + Composer + Node)
- `web` = Nginx (serves `/public`, forwards PHP to `app`)
- `db` = MariaDB 10.6
- `vite` = Vite dev server (dev only, from `docker-compose.override.yml`)

## Prerequisites (install once)

- Docker Desktop (Mac/Windows) or Docker Engine (Linux)
- Docker Compose v2 (`docker compose ...`)

## One-time setup (first run)

1) Start containers:

```bash
docker compose up -d --build
```

2) Install PHP dependencies:

```bash
docker compose exec app composer install
```

3) App environment:

- Laravel env file is `src/.env` (already present in this repo).
- If you ever create a fresh `.env`, generate a key:

```bash
docker compose exec app php artisan key:generate
```

4) Database tables:

```bash
docker compose exec app php artisan migrate --seed
docker compose exec app php artisan storage:link
```

Open the app:

- App: `http://localhost:8080`
- Vite: `http://localhost:5175`

> If ports are different on your machine, check the root `.env` (`APP_PORT`, `DB_PORT`, `VITE_PORT`).

Recommended (avoids URL/CSRF weirdness): set `APP_URL=http://localhost:8080` in `src/.env`.

## Daily workflow

Start / stop:

```bash
docker compose up -d
docker compose down
```

See logs:

```bash
docker compose logs -f web
docker compose logs -f app
docker compose logs -f vite
docker compose logs -f db
```

Run Artisan commands:

```bash
docker compose exec app php artisan about
docker compose exec app php artisan route:list
docker compose exec app php artisan migrate:fresh --seed
docker compose exec app php artisan tinker
```

Clear caches (common after env/config changes):

```bash
docker compose exec app php artisan optimize:clear
```

## Frontend (Vite)

The `vite` container runs `npm install` + `npm run dev` automatically (see `docker-compose.override.yml`).

- If the first run feels slow: it’s usually `npm install` inside the container.
- If you changed `VITE_PORT`, keep it in sync with `src/vite.config.js` (HMR client port).

Build production assets (rare for local dev):

```bash
docker compose exec app npm run build
```

## Queue / Schedule (when needed)

This app uses the database queue (`QUEUE_CONNECTION=database` in `src/.env`).

Run a queue worker (keep it running in a separate terminal):

```bash
docker compose exec app php artisan queue:work
```

Run the scheduler locally:

```bash
docker compose exec app php artisan schedule:work
```

## Database access

Connect from your host (TablePlus/DBeaver/etc):

- Host: `127.0.0.1`
- Port: `3309`
- User: `root`
- Password: `12345678`
- Database: `dashboard`

Connect from inside the DB container:

```bash
docker compose exec db mariadb -uroot -p12345678 dashboard
```

## Tests / Code style

Run tests:

```bash
docker compose exec app php artisan test
```

Run Pint (formatter):

```bash
docker compose exec app ./vendor/bin/pint
```

## Troubleshooting

- Port already in use: change `APP_PORT`, `DB_PORT`, or `VITE_PORT` in the root `.env`, then:
  ```bash
  docker compose down
  docker compose up -d
  ```
- “Class not found” / weird cache issues:
  ```bash
  docker compose exec app php artisan optimize:clear
  docker compose exec app composer dump-autoload
  ```
- Reset everything (WARNING: deletes DB data):
  ```bash
  docker compose down -v
  docker compose up -d --build
  ```
