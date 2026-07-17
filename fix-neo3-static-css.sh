#!/usr/bin/env bash
set -Eeuo pipefail

SCRIPT="/tmp/nexus-community-deploy.sh"
URL="https://raw.githubusercontent.com/galqnikilova-netizen/nexus-game-cms/main/deploy-community.sh"

wget -qO "${SCRIPT}" "${URL}"
chmod +x "${SCRIPT}"
exec bash "${SCRIPT}"
