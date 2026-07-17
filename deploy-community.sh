#!/usr/bin/env bash
set -Eeuo pipefail

DOMAIN="community.cs2monitor.eu"
ROOT="/home/${DOMAIN}"
APP="${ROOT}/nexus-game-cms"
WEB="${ROOT}/public_html"
BACKUPS="${ROOT}/backups"
STAMP="$(date +%Y%m%d-%H%M%S)"
TMP="$(mktemp -d)"
ARCHIVE="${TMP}/nexus-main.tar.gz"
SOURCE="${TMP}/source"

cleanup(){ rm -rf "${TMP}"; }
trap cleanup EXIT

[[ $EUID -eq 0 ]] || { echo "Run as root."; exit 1; }
mkdir -p "${ROOT}" "${BACKUPS}" "${SOURCE}"

OWNER="$(stat -c '%U' "${WEB}" 2>/dev/null || echo root)"
GROUP="$(stat -c '%G' "${WEB}" 2>/dev/null || echo root)"

export DEBIAN_FRONTEND=noninteractive
apt-get update -qq
apt-get install -y -qq curl wget tar unzip rsync git composer php-cli php-sqlite3 php-mbstring php-xml php-curl php-zip >/dev/null

wget -q --show-progress -O "${ARCHIVE}" "https://codeload.github.com/galqnikilova-netizen/nexus-game-cms/tar.gz/refs/heads/main"
tar -xzf "${ARCHIVE}" -C "${SOURCE}" --strip-components=1
[[ -f "${SOURCE}/artisan" ]] || { echo "Invalid project archive."; exit 1; }

if [[ -e "${APP}" ]]; then
  mv "${APP}" "${BACKUPS}/nexus-game-cms-${STAMP}"
fi
if [[ -e "${WEB}" || -L "${WEB}" ]]; then
  mv "${WEB}" "${BACKUPS}/public_html-${STAMP}"
fi

mv "${SOURCE}" "${APP}"
cd "${APP}"

cp .env.example .env
mkdir -p database storage/framework/{cache,sessions,views} storage/logs bootstrap/cache
touch database/database.sqlite

cat > .env <<EOF
APP_NAME="NEXUS Game CMS"
APP_ENV=production
APP_KEY=
APP_DEBUG=true
APP_URL=https://${DOMAIN}
APP_LOCALE=bg
APP_FALLBACK_LOCALE=en
LOG_CHANNEL=stack
LOG_LEVEL=debug
DB_CONNECTION=sqlite
DB_DATABASE=${APP}/database/database.sqlite
SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
FILESYSTEM_DISK=local
EOF

composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader
php artisan key:generate --force
php artisan optimize:clear
php artisan migrate --seed --force
php artisan storage:link --force || true
php artisan config:cache
php artisan route:cache
php artisan view:cache

ln -s "${APP}/public" "${WEB}"
chown -R "${OWNER}:${GROUP}" "${APP}"
chmod -R ug+rwX "${APP}/storage" "${APP}/bootstrap/cache" "${APP}/database"
find "${APP}" -type d -exec chmod 755 {} \;
find "${APP}" -type f -exec chmod 644 {} \;
chmod 775 "${APP}/storage" "${APP}/bootstrap/cache" "${APP}/database"
chmod 664 "${APP}/database/database.sqlite" "${APP}/.env"

if command -v systemctl >/dev/null 2>&1; then
  systemctl restart lsws 2>/dev/null || systemctl restart openlitespeed 2>/dev/null || true
fi

echo
echo "============================================================"
echo "NEXUS Neo3 Stage 3 deployed successfully"
echo "URL: https://${DOMAIN}"
echo "Backup: ${BACKUPS}"
echo "Owner: ${OWNER}:${GROUP}"
echo "============================================================"
