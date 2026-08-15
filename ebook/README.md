# AIT Publishing System

A lightweight, Composer-managed, filesystem-based professional publishing application.

## Architecture

- PHP 8.3+
- Composer / PSR-4
- No database
- OOP / SOLID-oriented domain structure
- Filesystem repositories
- In-memory editing model
- Deterministic pagination foundation
- Extensible component registry
- HTML/CSS component packages
- Templates and themes as resources
- Responsive terminal-style workspace
- Print-preview foundation

## Run

```bash
composer install
composer serve
```

Open `http://localhost:8080`.

## Storage

The filesystem is the persistence source of truth. Books are stored as portable directory packages under `storage/documents/books`.

## Important

This release is a developed architectural MVP/foundation, not a claim that every advanced publishing feature in the specification has been fully implemented. The pagination engine and renderer are intentionally structured so the remaining professional features can be added without replacing the core model.
