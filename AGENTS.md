# AGENTS.md — Poring Fix

## What this is
A static PWA (Progressive Web App) in Thai. No backend, no database, no build step. Pure static HTML/CSS/JS served by nginx.

## Repo history quirk
The original repo contained only a JPG image. The app source files (web/, android/) were embedded as a Python script inside the git commit message but never committed as actual files. The web/ files were extracted from that commit message and written to the repo.

## Structure
- `web/` — the PWA static site (served by nginx)
  - `index.html` — landing page
  - `repair/index.html` — main app page
  - `manifest.webmanifest` — PWA manifest
  - `sw.js` — service worker (offline caching)
  - `icon.svg` — app icon
- `android/` — Android WebView wrapper project (not needed for preview; only relevant for APK builds)

## Running
```
docker compose -f docker-compose.base44.yml up -d
```
Serves on port 3000. nginx serves `web/` directly from the bind mount — edits to files in `web/` are visible immediately (no rebuild needed).

## No secrets required
This is a pure static site with no external service dependencies.
