#!/usr/bin/env bash
set -Eeuo pipefail

DOMAIN="community.cs2monitor.eu"
ROOT="/home/${DOMAIN}"
APP="${ROOT}/public_html"
OWNER="commu1994"
GROUP="commu1994"
REPOSITORY="https://github.com/galqnikilova-netizen/nexus-game-cms.git"
STAGE1="/root/NEXUS_NEO3_HOME_STAGE1.run"
STAMP="$(date +%Y%m%d-%H%M%S)"
BACKUP="${ROOT}/public_html.before-rebuild.${STAMP}"
HAS_BACKUP=0

fail() {
  echo "[ERROR] $*" >&2
  exit 1
}

restore_on_error() {
  local code=$?
  echo
  echo "[ERROR] Clean rebuild failed with exit code ${code}."

  if [[ "${HAS_BACKUP}" == "1" && -d "${BACKUP}" ]]; then
    echo "Restoring previous public_html..."
    rm -rf "${APP}"
    mv "${BACKUP}" "${APP}"
    chown -R "${OWNER}:${GROUP}" "${APP}" || true
    echo "Previous public_html restored."
  fi

  exit "${code}"
}

trap restore_on_error ERR

[[ $EUID -eq 0 ]] || fail "Run this script as root."
[[ -f "${STAGE1}" ]] || fail "Stage 1 installer is missing: ${STAGE1}"
command -v git >/dev/null 2>&1 || fail "git is not installed."
command -v php >/dev/null 2>&1 || fail "php-cli is not installed."
command -v composer >/dev/null 2>&1 || fail "composer is not installed."

mkdir -p "${ROOT}"

if [[ -d "${APP}" ]]; then
  if find "${APP}" -mindepth 1 -maxdepth 1 -print -quit | grep -q .; then
    echo "Backing up current public_html to: ${BACKUP}"
    mv "${APP}" "${BACKUP}"
    HAS_BACKUP=1
  else
    rmdir "${APP}"
  fi
fi

echo "=== Cloning clean Laravel project ==="
git clone --depth 1 --branch main "${REPOSITORY}" "${APP}"

[[ -f "${APP}/artisan" ]] || fail "Laravel clone is incomplete: artisan is missing."
[[ -f "${APP}/deploy-community.sh" ]] || fail "Deployment script is missing from the repository."

chmod +x "${APP}/deploy-community.sh"

echo "=== Installing clean production application ==="
bash "${APP}/deploy-community.sh"

echo "=== Installing original Neo3 homepage Stage 1 ==="
bash "${STAGE1}"

chown -R "${OWNER}:${GROUP}" "${APP}"
/usr/local/lsws/bin/lswsctrl restart
sleep 3

echo "=== Final checks ==="
for PATHNAME in / /assets/neo3/; do
  STATUS="$(curl -ksS -o /dev/null -w '%{http_code}' --resolve "${DOMAIN}:443:127.0.0.1" "https://${DOMAIN}${PATHNAME}")"
  echo "${PATHNAME}: HTTP ${STATUS}"
  [[ "${STATUS}" == "200" || ( "${PATHNAME}" == "/assets/neo3/" && "${STATUS}" == "403" ) ]] || fail "HTTP check failed for ${PATHNAME}"
done

trap - ERR

echo
echo "============================================================"
echo "Clean Laravel rebuild completed successfully."
echo "Original Neo3 homepage Stage 1 installed."
echo "Application: ${APP}"
if [[ "${HAS_BACKUP}" == "1" ]]; then
  echo "Previous backup: ${BACKUP}"
fi
echo "============================================================"
