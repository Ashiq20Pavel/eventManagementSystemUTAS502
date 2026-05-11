#!/usr/bin/env bash
set -e

cp .env.example .env
php artisan key:generate
touch database/local.db
php artisan migrate --force
php artisan db:seed --force
npm install && npm run build

echo ""
echo "✅ Done! Run: php artisan serve"
echo ""
echo "  Admin:     admin@eventportal.com / password"
echo "  Organiser: sarah@eventsco.com / password"
echo "  Attendee:  alice@example.com / password"