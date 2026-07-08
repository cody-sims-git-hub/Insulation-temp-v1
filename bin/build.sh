#!/usr/bin/env bash
# Build the theme's CSS/JS (Tailwind + Alpine) into theme/dist using a throwaway
# Node container — no host Node required. Run after editing theme/src.
set -euo pipefail
cd "$(dirname "$0")/.."
docker run --rm -v "$PWD/theme:/app" -w /app node:20 \
  sh -c "npm install --no-audit --no-fund && npm run build"
echo "Built theme/dist/app.css and theme/dist/app.js"
