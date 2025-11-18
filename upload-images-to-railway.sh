#!/bin/bash
# Script untuk upload gambar ke Railway storage
# Usage: ./upload-images-to-railway.sh

echo "═══════════════════════════════════════════════════════════"
echo "  Upload Images to Railway Storage"
echo "═══════════════════════════════════════════════════════════"
echo ""

GALLERY_DIR="storage/app/public/gallery"
RAILWAY_SERVICE="elfa"

if [ ! -d "$GALLERY_DIR" ]; then
    echo "❌ Gallery directory not found: $GALLERY_DIR"
    exit 1
fi

echo "📁 Found gallery directory: $GALLERY_DIR"
echo "📊 Counting images..."
IMAGE_COUNT=$(find "$GALLERY_DIR" -type f \( -name "*.jpg" -o -name "*.jpeg" -o -name "*.png" -o -name "*.gif" \) | wc -l)
echo "   Total images: $IMAGE_COUNT"
echo ""

echo "🚀 Uploading images to Railway..."
echo ""

# Upload each image
UPLOADED=0
FAILED=0

for image in "$GALLERY_DIR"/*.{jpg,jpeg,png,gif} 2>/dev/null; do
    if [ -f "$image" ]; then
        filename=$(basename "$image")
        echo "   Uploading: $filename..."
        
        # Use Railway CLI to copy file
        if railway run cp "$image" "storage/app/public/gallery/$filename" 2>/dev/null; then
            echo "   ✅ $filename uploaded"
            ((UPLOADED++))
        else
            echo "   ⚠️  Failed to upload $filename (file may already exist)"
            ((FAILED++))
        fi
    fi
done

echo ""
echo "═══════════════════════════════════════════════════════════"
echo "  Upload Complete!"
echo "═══════════════════════════════════════════════════════════"
echo "✅ Uploaded: $UPLOADED"
echo "⚠️  Failed: $FAILED"
echo ""
echo "💡 Note: Railway uses ephemeral filesystem."
echo "   Files will be lost on redeploy unless using Railway Volume."
echo ""

