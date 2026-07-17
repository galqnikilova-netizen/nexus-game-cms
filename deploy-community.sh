#!/usr/bin/env bash
set -Eeuo pipefail

DOMAIN="community.cs2monitor.eu"
ROOT="/home/${DOMAIN}"
APP="${ROOT}/public_html"
OWNER="commu1994"
GROUP="commu1994"
BACKUPS="${ROOT}/backups"
REPOSITORY="https://github.com/galqnikilova-netizen/nexus-game-cms.git"
STAMP="$(date +%Y%m%d-%H%M%S)"

fail(){ echo "[ERROR] $*" >&2; exit 1; }

[[ $EUID -eq 0 ]] || fail "Run this script as root."
[[ -d "${APP}" ]] || fail "Application directory is missing: ${APP}"
[[ -f "${APP}/artisan" ]] || fail "Laravel artisan file is missing: ${APP}/artisan"
command -v git >/dev/null 2>&1 || fail "git is not installed."
command -v composer >/dev/null 2>&1 || fail "composer is not installed."
command -v php >/dev/null 2>&1 || fail "php-cli is not installed."

mkdir -p "${BACKUPS}"

if [[ -f "${APP}/.env" ]]; then
  cp -a "${APP}/.env" "${BACKUPS}/community.env.${STAMP}"
fi
if [[ -f "${APP}/database/database.sqlite" ]]; then
  cp -a "${APP}/database/database.sqlite" "${BACKUPS}/community.sqlite.${STAMP}"
fi

echo "=== Updating project from GitHub main ==="
cd "${APP}"
git config --global --add safe.directory "${APP}" 2>/dev/null || true

if [[ ! -d .git ]]; then
  echo "=== Initializing Git metadata in existing production directory ==="
  git init
  git remote add origin "${REPOSITORY}"
else
  if git remote get-url origin >/dev/null 2>&1; then
    git remote set-url origin "${REPOSITORY}"
  else
    git remote add origin "${REPOSITORY}"
  fi
fi

git fetch --prune origin main
git reset --hard origin/main

[[ -f public/assets/css/neo3-exact-core.css ]] || fail "neo3-exact-core.css is missing after update."
[[ -f public/assets/css/neo3-exact-home.css ]] || fail "neo3-exact-home.css is missing after update."
[[ -f public/assets/css/neo3-nexus-adapter.css ]] || fail "neo3-nexus-adapter.css is missing after update."

rm -f public/neo3-stage1-asset.php

mkdir -p \
  storage/framework/cache/data \
  storage/framework/sessions \
  storage/framework/views \
  storage/logs \
  bootstrap/cache \
  database

touch database/database.sqlite

if [[ ! -f .env ]]; then
  cp .env.example .env
  sed -i "s#^APP_URL=.*#APP_URL=https://${DOMAIN}#" .env
  sed -i "s#^DB_CONNECTION=.*#DB_CONNECTION=sqlite#" .env
  sed -i "s#^DB_DATABASE=.*#DB_DATABASE=${APP}/database/database.sqlite#" .env
fi

sed -i 's/^APP_ENV=.*/APP_ENV=production/' .env
sed -i 's/^APP_DEBUG=.*/APP_DEBUG=false/' .env
sed -i "s#^APP_URL=.*#APP_URL=https://${DOMAIN}#" .env
sed -i 's/^LOG_LEVEL=.*/LOG_LEVEL=error/' .env
sed -i 's/^DB_CONNECTION=.*/DB_CONNECTION=sqlite/' .env
sed -i "s#^DB_DATABASE=.*#DB_DATABASE=${APP}/database/database.sqlite#" .env

chown -R "${OWNER}:${GROUP}" "${APP}"
find "${APP}" -type d -exec chmod 755 {} \;
find "${APP}" -type f -exec chmod 644 {} \;
find storage bootstrap/cache database -type d -exec chmod 775 {} \;
find storage bootstrap/cache database -type f -exec chmod 664 {} \;
chmod 640 .env

echo "=== Installing production dependencies ==="
runuser -u "${OWNER}" -- composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader

if ! grep -q '^APP_KEY=base64:' .env; then
  runuser -u "${OWNER}" -- php artisan key:generate --force
fi

runuser -u "${OWNER}" -- php artisan optimize:clear
runuser -u "${OWNER}" -- php artisan migrate --force
runuser -u "${OWNER}" -- php artisan config:cache
runuser -u "${OWNER}" -- php artisan route:cache
runuser -u "${OWNER}" -- php artisan view:cache

/usr/local/lsws/bin/lswsctrl restart
sleep 3

echo "=== Production checks ==="
for PATHNAME in \
  / \
  /leaderboard \
  /store \
  /assets/css/neo3-exact-core.css \
  /assets/css/neo3-exact-home.css \
  /assets/css/neo3-nexus-adapter.css
 do
  STATUS="$(curl -ksS -o /dev/null -w '%{http_code}' --resolve "${DOMAIN}:443:127.0.0.1" "https://${DOMAIN}${PATHNAME}")"
  TYPE="$(curl -ksSI --resolve "${DOMAIN}:443:127.0.0.1" "https://${DOMAIN}${PATHNAME}" | awk -F': ' 'tolower($1)=="content-type"{gsub("\r","");print $2;exit}')"
  echo "${PATHNAME}: HTTP ${STATUS} | ${TYPE:-unknown}"
  [[ "${STATUS}" == "200" ]] || fail "HTTP check failed for ${PATHNAME}"
 done

echo
echo "============================================================"
echo "NEXUS production update completed successfully"
echo "Application: ${APP}"
echo "Document root: ${APP}/public"
echo "Backup directory: ${BACKUPS}"
echo "============================================================"
