<?php

declare(strict_types=1);

$assets = [
    'core' => ['public/assets/css/neo3-exact-core.css', 'text/css; charset=UTF-8'],
    'home' => ['public/assets/css/neo3-exact-home.css', 'text/css; charset=UTF-8'],
    'adapter' => ['public/assets/css/neo3-nexus-adapter.css', 'text/css; charset=UTF-8'],
];

$key = (string) ($_GET['file'] ?? '');
if (! isset($assets[$key])) {
    http_response_code(404);
    exit('Unknown Neo3 asset.');
}

[$archivePath, $contentType] = $assets[$key];
$root = dirname(__DIR__);
$bundlePath = $root.'/.bootstrap/neo3-stage1.b64';
$cacheDir = $root.'/storage/framework/cache/neo3-stage1';
$cachePath = $cacheDir.'/'.basename($archivePath);

if (! is_file($cachePath)) {
    $encoded = is_file($bundlePath) ? file_get_contents($bundlePath) : false;
    $compressed = is_string($encoded) ? base64_decode(preg_replace('/\s+/', '', $encoded), true) : false;
    $tar = is_string($compressed) ? gzdecode($compressed) : false;

    if (! is_string($tar)) {
        http_response_code(500);
        exit('Neo3 asset bundle is unavailable.');
    }

    $offset = 0;
    $length = strlen($tar);
    $content = null;

    while ($offset + 512 <= $length) {
        $header = substr($tar, $offset, 512);
        if ($header === str_repeat("\0", 512)) {
            break;
        }

        $name = rtrim(substr($header, 0, 100), "\0");
        $prefix = rtrim(substr($header, 345, 155), "\0");
        $fullName = $prefix !== '' ? $prefix.'/'.$name : $name;
        $sizeField = trim(substr($header, 124, 12), " \0");
        $size = $sizeField === '' ? 0 : octdec($sizeField);
        $dataOffset = $offset + 512;

        if ($fullName === $archivePath) {
            $content = substr($tar, $dataOffset, $size);
            break;
        }

        $offset = $dataOffset + (int) (ceil($size / 512) * 512);
    }

    if (! is_string($content)) {
        http_response_code(404);
        exit('Neo3 asset was not found in the bundle.');
    }

    if (! is_dir($cacheDir)) {
        @mkdir($cacheDir, 0775, true);
    }
    @file_put_contents($cachePath, $content, LOCK_EX);
} else {
    $content = file_get_contents($cachePath);
}

if (! is_string($content)) {
    http_response_code(500);
    exit('Neo3 asset could not be loaded.');
}

$etag = '"'.sha1($content).'"';
if (trim((string) ($_SERVER['HTTP_IF_NONE_MATCH'] ?? '')) === $etag) {
    http_response_code(304);
    exit;
}

header('Content-Type: '.$contentType);
header('Cache-Control: public, max-age=31536000, immutable');
header('ETag: '.$etag);
header('X-Content-Type-Options: nosniff');
echo $content;
