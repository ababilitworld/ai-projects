<?php
header('Content-Type: application/json; charset=utf-8');
$host = strtolower((string) ($_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? ''));
$host = preg_replace('/:\d+$/', '', $host) ?? $host;
echo json_encode([
 'phpVersion'=>PHP_VERSION,
 'host'=>$host,
 'localDevelopment'=>$host==='localhost'||$host==='127.0.0.1'||str_ends_with($host,'.test')||str_ends_with($host,'.localhost')||str_ends_with($host,'.local'),
 'extensions'=>['curl'=>extension_loaded('curl'),'dom'=>extension_loaded('dom'),'openssl'=>extension_loaded('openssl')],
 'curl.cainfo'=>ini_get('curl.cainfo'),
 'openssl.cafile'=>ini_get('openssl.cafile'),
], JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
