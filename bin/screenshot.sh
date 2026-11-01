#!/usr/bin/env bash
# Headless Edge/Chrome screenshot helper for visual QA.
# Usage: bin/screenshot.sh <url> <out.png> [width=1234] [height=800]
URL="$1"; OUT="$2"; W="${3:-1234}"; H="${4:-800}"
BROWSER="${BROWSER:-/c/Program Files (x86)/Microsoft/Edge/Application/msedge.exe}"
"$BROWSER" --headless --disable-gpu --hide-scrollbars --force-device-scale-factor=1 --virtual-time-budget=6000 --window-size="$W,$H" --screenshot="$(cygpath -w "$OUT")" "$URL" >/dev/null 2>&1
