#!/usr/bin/env bash
set -Eeuo pipefail

DOMAIN="community.cs2monitor.eu"
ROOT="/home/${DOMAIN}"
APP="${ROOT}/nexus-game-cms"
WEB="${ROOT}/public_html"
BACKUPS="${ROOT}/backups"
STAMP="$(date +%Y%m%d-%H%M%S)"

[[ $EUID -eq 0 ]] || { echo "Run as root."; exit 1; }
[[ -f "${APP}/artisan" ]] || { echo "Laravel app not found at ${APP}"; exit 1; }

ORIGINAL="$(find "${BACKUPS}" -maxdepth 1 -type d -name 'public_html-*' 2>/dev/null | sort | tail -n1 || true)"
if [[ -n "${ORIGINAL}" ]]; then
  OWNER="$(stat -c '%U' "${ORIGINAL}")"
  GROUP="$(stat -c '%G' "${ORIGINAL}")"
else
  OWNER="$(stat -c '%U' "${ROOT}")"
  GROUP="$(stat -c '%G' "${ROOT}")"
fi

if [[ -L "${WEB}" ]]; then
  rm -f "${WEB}"
elif [[ -d "${WEB}" ]]; then
  mv "${WEB}" "${BACKUPS}/public_html-hotfix-${STAMP}"
fi
mkdir -p "${WEB}"

rsync -a --delete "${APP}/public/" "${WEB}/"

cat > "${WEB}/index.php" <<'PHP'
<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/../nexus-game-cms/storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../nexus-game-cms/vendor/autoload.php';

/** @var Application $app */
$app = require_once __DIR__.'/../nexus-game-cms/bootstrap/app.php';

$app->handleRequest(Request::capture());
PHP

if [[ -f "${WEB}/neo3-stage1-asset.php" ]]; then
  sed -i "s#\$root = dirname(__DIR__);#\$root = dirname(__DIR__).'/nexus-game-cms';#" "${WEB}/neo3-stage1-asset.php"
fi

cd "${APP}"
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

chown -R "${OWNER}:${GROUP}" "${APP}" "${WEB}"
find "${WEB}" -type d -exec chmod 755 {} \;
find "${WEB}" -type f -exec chmod 644 {} \;
chmod -R ug+rwX "${APP}/storage" "${APP}/bootstrap/cache" "${APP}/database"

systemctl restart lsws 2>/dev/null || systemctl restart openlitespeed 2>/dev/null || true

STATUS="$(curl -ksS -o /tmp/community-check.html -w '%{http_code}' --resolve "${DOMAIN}:443:127.0.0.1" "https://${DOMAIN}/" || true)"

echo
echo "============================================================"
echo "public_html hotfix applied"
echo "Owner: ${OWNER}:${GROUP}"
echo "Local HTTPS status: ${STATUS}"
echo "URL: https://${DOMAIN}"
echo "============================================================"

if [[ "${STATUS}" != "200" ]]; then
  echo "--- OpenLiteSpeed error log (last 30 lines) ---"
  tail -n 30 /usr/local/lsws/logs/error.log 2>/dev/null || true
  echo "--- Laravel log (last 30 lines) ---"
  tail -n 30 "${APP}/storage/logs/laravel.log" 2>/dev/null || true
fi
