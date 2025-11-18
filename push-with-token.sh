#!/bin/bash
# Script untuk push dengan Personal Access Token

echo "═══════════════════════════════════════════════════════════"
echo "  Push ke GitHub dengan Personal Access Token"
echo "═══════════════════════════════════════════════════════════"
echo ""
echo "Masukkan Personal Access Token Anda:"
read -s TOKEN

if [ -z "$TOKEN" ]; then
    echo "❌ Token tidak boleh kosong!"
    exit 1
fi

# Set remote dengan token
git remote set-url origin https://${TOKEN}@github.com/elfarena/ujikom-elfarena.git

echo ""
echo "✅ Remote URL sudah diupdate dengan token"
echo ""
echo "Mencoba push ke origin main..."
git push origin main

echo ""
echo "═══════════════════════════════════════════════════════════"
echo "  Selesai!"
echo "═══════════════════════════════════════════════════════════"

