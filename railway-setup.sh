#!/bin/bash
# Railway Setup Script
# Script untuk setup storage link dan optimasi di Railway

set -e

echo "═══════════════════════════════════════════════════════════"
echo "  Railway Setup Script"
echo "═══════════════════════════════════════════════════════════"
echo ""

# Create storage link (ignore error if already exists)
echo "📁 Creating storage symlink..."
php artisan storage:link || echo "⚠️  Storage link already exists or failed (this is OK)"

# Clear caches
echo "🧹 Clearing caches..."
php artisan config:clear || true
php artisan cache:clear || true
php artisan route:clear || true
php artisan view:clear || true

# Optimize for production
echo "⚡ Optimizing for production..."
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Set permissions
echo "🔐 Setting permissions..."
chmod -R 755 storage bootstrap/cache || true

echo ""
echo "✅ Setup complete!"
echo ""

