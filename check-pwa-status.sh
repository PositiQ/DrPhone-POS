#!/bin/bash

# PWA Update Check Script
# Run this periodically to check for service worker updates

echo "🔍 Checking PWA Service Worker Status..."

# Check if files exist
echo ""
echo "📁 Checking PWA Files:"

files=("manifest.json" "service-worker.js" "offline.html" "pwa-client.js")

for file in "${files[@]}"; do
  if [ -f "$file" ]; then
    size=$(du -h "$file" | cut -f1)
    echo "  ✅ $file ($size)"
  else
    echo "  ❌ $file - NOT FOUND!"
  fi
done

# Validate manifest.json
echo ""
echo "📋 Validating manifest.json:"

if command -v jq &> /dev/null; then
  if jq empty manifest.json 2>/dev/null; then
    echo "  ✅ manifest.json is valid JSON"
    echo "  - Name: $(jq -r '.name' manifest.json)"
    echo "  - Start URL: $(jq -r '.start_url' manifest.json)"
    echo "  - Display: $(jq -r '.display' manifest.json)"
  else
    echo "  ❌ manifest.json is invalid JSON"
  fi
else
  echo "  ⚠️  jq not installed - skipping validation"
fi

# Check file sizes
echo ""
echo "📊 File Sizes:"
du -h manifest.json service-worker.js offline.html pwa-client.js 2>/dev/null

echo ""
echo "✨ PWA Status Check Complete!"
echo ""
echo "Server should be running on port 3000"
echo "Access: http://localhost:3000"
