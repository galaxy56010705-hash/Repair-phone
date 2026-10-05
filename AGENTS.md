# Development notes

- The imported repository originally contained only `IMG-20260927-WA0000.jpg`. The calculator is recreated from that reference; browser chrome is not part of the app.
- Use `docker compose -f docker-compose.base44.yml up -d` for the preview. PHP runs directly from bind-mounted source and reads changes on each request, with no build or dependency installation. Refresh the preview after source edits (there is no HMR).
- No external services, credentials, database, or package dependencies are needed.
- Verify syntax with `docker compose -f docker-compose.base44.yml exec -T web php -l index.php`.
- GET `/` serves the calculator; POST `/index.php` accepts form fields `first`, `second`, and `operation` (`add`, `subtract`, `multiply`, `divide`) and returns JSON. Invalid numbers, invalid operations, division by zero, and nonfinite results return 422.
- Verify calculations with `curl -X POST http://localhost:3000/index.php -d 'first=12&second=3&operation=divide'`. The expected response is `{"result":4}`.
