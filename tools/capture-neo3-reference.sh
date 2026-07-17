#!/usr/bin/env bash
set -Eeuo pipefail

BASE_URL="${1:-https://neo3.edragon.ru}"
OUTPUT_DIR="${2:-$PWD/neo3-reference}"
COOKIE_FILE="${3:-}"

BASE_URL="${BASE_URL%/}"
HOST="$(printf '%s' "$BASE_URL" | sed -E 's#^https?://([^/]+).*#\1#')"
STAMP="$(date -u +%Y%m%dT%H%M%SZ)"
RUN_DIR="$OUTPUT_DIR/$STAMP"
RAW_DIR="$RUN_DIR/html-raw"
MIRROR_DIR="$RUN_DIR/mirror"
CSS_DIR="$RUN_DIR/css-original"
META_DIR="$RUN_DIR/meta"

mkdir -p "$RAW_DIR" "$MIRROR_DIR" "$CSS_DIR" "$META_DIR"

if ! command -v curl >/dev/null 2>&1; then
    echo "Missing dependency: curl" >&2
    exit 1
fi

if ! command -v wget >/dev/null 2>&1; then
    echo "Missing dependency: wget" >&2
    exit 1
fi

COOKIE_ARGS=()
WGET_COOKIE_ARGS=()
if [[ -n "$COOKIE_FILE" ]]; then
    if [[ ! -f "$COOKIE_FILE" ]]; then
        echo "Cookie file not found: $COOKIE_FILE" >&2
        exit 1
    fi
    COOKIE_ARGS=(--cookie "$COOKIE_FILE")
    WGET_COOKIE_ARGS=(--load-cookies "$COOKIE_FILE" --keep-session-cookies)
fi

ROUTES=(
    "/"
    "/leaderboard"
    "/punishment"
    "/store"
    "/profiles"
    "/faq"
    "/help"
    "/tickets"
    "/skinchanger"
)

CSS_URLS=(
    "$BASE_URL/app/templates/neo_remastered/assets/css/style.css?1784267230"
    "$BASE_URL/storage/assets/css/style.css?1784267230"
)

echo "Capturing Neo 3 reference from $BASE_URL"
echo "Output: $RUN_DIR"

for route in "${ROUTES[@]}"; do
    slug="$(printf '%s' "$route" | sed 's#^/##; s#[/?&=]#_#g')"
    [[ -n "$slug" ]] || slug="home"
    status="$(curl -L --silent --show-error --output "$RAW_DIR/$slug.html" --write-out '%{http_code}' \
        --user-agent 'Mozilla/5.0 Neo3ReferenceCapture/1.0' \
        "${COOKIE_ARGS[@]}" "$BASE_URL$route")"
    printf '%-28s %s\n' "$route" "$status" | tee -a "$META_DIR/http-status.txt"
done

for index in "${!CSS_URLS[@]}"; do
    name="$(printf '%02d' "$((index + 1))")-$(basename "${CSS_URLS[$index]%%\?*}")"
    curl -L --fail --silent --show-error \
        --user-agent 'Mozilla/5.0 Neo3ReferenceCapture/1.0' \
        "${COOKIE_ARGS[@]}" "${CSS_URLS[$index]}" -o "$CSS_DIR/$name"
done

for route in "${ROUTES[@]}"; do
    wget --quiet \
        --page-requisites \
        --convert-links \
        --adjust-extension \
        --span-hosts \
        --domains "$HOST" \
        --directory-prefix "$MIRROR_DIR" \
        --user-agent='Mozilla/5.0 Neo3ReferenceCapture/1.0' \
        "${WGET_COOKIE_ARGS[@]}" \
        "$BASE_URL$route" || true
done

find "$RUN_DIR" -type f -print0 | sort -z | xargs -0 sha256sum > "$META_DIR/SHA256SUMS"
find "$RUN_DIR" -type f | sort > "$META_DIR/FILES.txt"

cat > "$META_DIR/README.txt" <<EOF
Neo 3 reference capture
=======================
Source: $BASE_URL
UTC capture: $STAMP

html-raw/     Exact server HTML responses before link conversion.
css-original/ The two explicitly requested CSS files.
mirror/       Page requisites downloaded by wget (CSS, JS, images, fonts).
meta/         HTTP statuses, file inventory and SHA-256 checksums.

If authenticated pages returned login HTML, export a Netscape-format cookies.txt
from your own browser and run this script again with its path as argument 3.
Never send cookies.txt to another person and delete it after the capture.
EOF

archive="$OUTPUT_DIR/neo3-reference-$STAMP.tar.gz"
tar -C "$OUTPUT_DIR" -czf "$archive" "$STAMP"

echo
echo "Capture complete."
echo "Folder:  $RUN_DIR"
echo "Archive: $archive"
echo "Files:   $(find "$RUN_DIR" -type f | wc -l)"
