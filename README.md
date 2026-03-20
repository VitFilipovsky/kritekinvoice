# KritekInvoice

Invoicing application built on Symfony + Bootstrap + Hotwire Turbo.

## Architecture

The project runs in three Docker containers:

| Container | Image | Purpose | Port |
|---|---|---|---|
| `kritekinvoice_php` | custom (PHP + Apache) | Symfony application | 80 |
| `kritekinvoice_mysql` | custom (MySQL) | Database | 3306 |
| `kritekinvoice_node` | custom (Node.js) | Webpack Encore, JS/CSS build | 4200 |

```
┌─────────────────────────────────────────────┐
│                   Host                      │
│                                             │
│  :80 ──► kritekinvoice_php (Symfony/Apache) │
│            │                                │
│            └──► kritekinvoice_mysql         │
│                                             │
│  kritekinvoice_node (Webpack Encore)        │
└─────────────────────────────────────────────┘
```

The application source code is located in the `app/` directory and is shared into containers via a Docker volume.

## Project Initialization

> Starts containers, creates a fresh database, runs migrations and builds JS/CSS assets.

```bash
make init
```

⚠️ **Warning:** `make init` will permanently delete all data in the database.

## Available Commands

```bash
make help            # show all available commands
make php             # open shell in PHP container
make mysql           # open shell in MySQL container
make node            # open shell in Node.js container
make composer-install
make npm-install
make npm-build
make npm-watch       # Webpack watch mode (development)
make cache-clear     # clear Symfony cache
make phpstan         # run static analysis
make phpcs           # check code formatting
```

## Requirements

- Docker
- Docker Compose (plugin or standalone)
- Make
