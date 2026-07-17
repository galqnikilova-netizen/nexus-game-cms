#!/usr/bin/env bash
set -Eeuo pipefail

APP="/home/community.cs2monitor.eu/nexus-game-cms"
WEB="/home/community.cs2monitor.eu/public_html"
OWNER="commu1994"
GROUP="commu1994"
BUNDLE="${APP}/.bootstrap/neo3-stage1.b64"
TMP="$(mktemp -d)"
ARCHIVE="${TMP}/neo3-stage1.tar.gz"
EXTRACT="${TMP}/extract"

cleanup(){ rm -rf "${TMP}"; }
trap cleanup EXIT

[[ $EUID -eq 0 ]] || { echo "Run as root."; exit 1; }
[[ -f "${APP}/artisan" ]] || { echo "Laravel app not found: ${APP}"; exit 1; }
[[ -f "${BUNDLE}" ]] || { echo "Neo3 bundle not found: ${BUNDLE}"; exit 1; }

mkdir -p "${EXTRACT}" "${APP}/public/assets/css" "${WEB}/assets/css"
base64 --decode "${BUNDLE}" > "${ARCHIVE}"
tar -tzf "${ARCHIVE}" >/dev/null
tar -xzf "${ARCHIVE}" -C "${EXTRACT}"

for FILE in neo3-exact-core.css neo3-exact-home.css neo3-nexus-adapter.css; do
  SOURCE="${EXTRACT}/public/assets/css/${FILE}"
  [[ -s "${SOURCE}" ]] || { echo "Missing CSS in bundle: ${FILE}"; exit 1; }
  install -m 0644 -o "${OWNER}" -g "${GROUP}" "${SOURCE}" "${APP}/public/assets/css/${FILE}"
  install -m 0644 -o "${OWNER}" -g "${GROUP}" "${SOURCE}" "${WEB}/assets/css/${FILE}"
done

python3 - <<'PY'
from pathlib import Path
layout = Path('/home/community.cs2monitor.eu/nexus-game-cms/resources/views/layouts/neo3.blade.php')
text = layout.read_text(encoding='utf-8')
replacements = {
    "{{ asset('neo3-stage1-asset.php?file=core') }}": "{{ asset('assets/css/neo3-exact-core.css') }}",
    "{{ asset('neo3-stage1-asset.php?file=home') }}": "{{ asset('assets/css/neo3-exact-home.css') }}",
    "{{ asset('neo3-stage1-asset.php?file=adapter') }}": "{{ asset('assets/css/neo3-nexus-adapter.css') }}",
}
for old, new in replacements.items():
    text = text.replace(old, new)
layout.write_text(text, encoding='utf-8')
PY

chown "${OWNER}:${GROUP}" "${APP}/resources/views/layouts/neo3.blade.php"
chmod 0644 "${APP}/resources/views/layouts/neo3.blade.php"
rm -f "${WEB}/neo3-stage1-asset.php"

cd "${APP}"
runuser -u "${OWNER}" -- php artisan optimize:clear
runuser -u "${OWNER}" -- php artisan config:cache
runuser -u "${OWNER}" -- php artisan route:cache
runuser -u "${OWNER}" -- php artisan view:cache

/usr/local/lsws/bin/lswsctrl restart
sleep 3

echo "=== STATIC CSS TESTS ==="
for FILE in neo3-exact-core.css neo3-exact-home.css neo3-nexus-adapter.css; do
  STATUS="$(curl -ksS -o /dev/null -w '%{http_code}' --resolve community.cs2monitor.eu:443:127.0.0.1 "https://community.cs2monitor.eu/assets/css/${FILE}")"
  TYPE="$(curl -ksSI --resolve community.cs2monitor.eu:443:127.0.0.1 "https://community.cs2monitor.eu/assets/css/${FILE}" | awk -F': ' 'tolower($1)=="content-type"{gsub("\r","");print $2;exit}')"
  SIZE="$(stat -c '%s' "${WEB}/assets/css/${FILE}")"
  echo "${FILE}: HTTP ${STATUS} | ${TYPE:-no-content-type} | ${SIZE} bytes"
done

PAGE_STATUS="$(curl -ksS -o /dev/null -w '%{http_code}' --resolve community.cs2monitor.eu:443:127.0.0.1 https://community.cs2monitor.eu/)"
echo "Homepage: HTTP ${PAGE_STATUS}"
echo "Neo3 static CSS hotfix completed."
