<?php

/**
 * Diagnostic probe for elicpovietnam.click
 *
 * Place this file inside the folder that is configured as the domain's
 * document root (the one holding index.php). Open it in the browser and
 * it prints everything we need to know about the server.
 */

header('Content-Type: text/plain; charset=utf-8');

$publicDir = __DIR__;
$rootDir = dirname($publicDir);

$report = [];
$report['timestamp'] = date('c');
$report['php_version'] = PHP_VERSION;
$report['php_version_id'] = PHP_VERSION_ID;
$report['sapi'] = PHP_SAPI;
$report['display_errors'] = ini_get('display_errors');
$report['error_reporting'] = error_reporting();
$report['max_execution_time'] = ini_get('max_execution_time');
$report['memory_limit'] = ini_get('memory_limit');
$report['doc_root'] = $_SERVER['DOCUMENT_ROOT'] ?? null;
$report['script_filename'] = $_SERVER['SCRIPT_FILENAME'] ?? null;
$report['server_software'] = $_SERVER['SERVER_SOFTWARE'] ?? null;

$report['extensions'] = [
    'pdo' => extension_loaded('pdo'),
    'pdo_mysql' => extension_loaded('pdo_mysql'),
    'mbstring' => extension_loaded('mbstring'),
    'openssl' => extension_loaded('openssl'),
    'fileinfo' => extension_loaded('fileinfo'),
    'curl' => extension_loaded('curl'),
    'zip' => extension_loaded('zip'),
    'gd' => extension_loaded('gd'),
    'intl' => extension_loaded('intl'),
    'tokenizer' => extension_loaded('tokenizer'),
    'xml' => extension_loaded('xml'),
    'ctype' => extension_loaded('ctype'),
    'json' => extension_loaded('json'),
    'bcmath' => extension_loaded('bcmath'),
];

$paths = [
    'root_dir' => $rootDir,
    'public_dir' => $publicDir,
    'vendor_dir' => $rootDir.'/vendor',
    'vendor_autoload' => $rootDir.'/vendor/autoload.php',
    'public_vendor_autoload' => $publicDir.'/vendor/autoload.php',
    'bootstrap_app' => $rootDir.'/bootstrap/app.php',
    'artisan' => $rootDir.'/artisan',
    'env_file' => $rootDir.'/.env',
    'storage_dir' => $rootDir.'/storage',
    'storage_logs' => $rootDir.'/storage/logs',
    'bootstrap_cache' => $rootDir.'/bootstrap/cache',
    'public_build' => $publicDir.'/build',
    'public_build_manifest' => $publicDir.'/build/manifest.json',
    'public_storage' => $publicDir.'/storage',
    'public_images' => $publicDir.'/images',
    'error_log_file' => $rootDir.'/error_log',
    'public_error_log_file' => $publicDir.'/error_log',
];

$report['paths'] = [];
foreach ($paths as $label => $path) {
    $report['paths'][$label] = [
        'path' => $path,
        'exists' => file_exists($path),
        'is_dir' => is_dir($path),
        'readable' => is_readable($path),
        'writable' => is_writable($path),
    ];
}

$report['public_dir_listing'] = [];
foreach (scandir($publicDir) ?: [] as $entry) {
    if ($entry === '.' || $entry === '..') {
        continue;
    }
    $full = $publicDir.'/'.$entry;
    $report['public_dir_listing'][] = [
        'name' => $entry,
        'is_dir' => is_dir($full),
        'size' => is_dir($full) ? null : (@filesize($full) ?: null),
        'modified' => @date('Y-m-d H:i:s', @filemtime($full)) ?: null,
    ];
}

$report['root_dir_listing'] = [];
if (is_dir($rootDir)) {
    foreach (scandir($rootDir) ?: [] as $entry) {
        if ($entry === '.' || $entry === '..') {
            continue;
        }
        $full = $rootDir.'/'.$entry;
        $report['root_dir_listing'][] = [
            'name' => $entry,
            'is_dir' => is_dir($full),
            'modified' => @date('Y-m-d H:i:s', @filemtime($full)) ?: null,
        ];
    }
}

// Parse .env without exposing secrets.
$report['env'] = null;
$envPath = $rootDir.'/.env';
if (is_readable($envPath)) {
    $env = [];
    foreach (file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [] as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || ! str_contains($line, '=')) {
            continue;
        }
        [$key, $value] = explode('=', $line, 2);
        $env[trim($key)] = trim(trim($value), "\"'");
    }
    $report['env'] = [
        'APP_ENV' => $env['APP_ENV'] ?? null,
        'APP_DEBUG' => $env['APP_DEBUG'] ?? null,
        'APP_URL' => $env['APP_URL'] ?? null,
        'APP_KEY_present' => isset($env['APP_KEY']) && $env['APP_KEY'] !== '',
        'DB_CONNECTION' => $env['DB_CONNECTION'] ?? null,
        'DB_HOST' => $env['DB_HOST'] ?? null,
        'DB_PORT' => $env['DB_PORT'] ?? null,
        'DB_DATABASE' => $env['DB_DATABASE'] ?? null,
        'DB_USERNAME_present' => isset($env['DB_USERNAME']) && $env['DB_USERNAME'] !== '',
        'DB_PASSWORD_present' => isset($env['DB_PASSWORD']) && $env['DB_PASSWORD'] !== '',
        'CACHE_STORE' => $env['CACHE_STORE'] ?? null,
        'SESSION_DRIVER' => $env['SESSION_DRIVER'] ?? null,
        'QUEUE_CONNECTION' => $env['QUEUE_CONNECTION'] ?? null,
        'FILESYSTEM_DISK' => $env['FILESYSTEM_DISK'] ?? null,
    ];
}

// Try loading Laravel to see the real failure.
$report['laravel_boot'] = null;
$autoloadCandidates = [$rootDir.'/vendor/autoload.php', $publicDir.'/vendor/autoload.php'];
$loaded = false;
foreach ($autoloadCandidates as $candidate) {
    if (is_readable($candidate)) {
        try {
            require_once $candidate;
            $loaded = true;
            $report['laravel_boot']['autoload_path'] = $candidate;
            $report['laravel_boot']['autoload_ok'] = true;
        } catch (Throwable $e) {
            $report['laravel_boot']['autoload_path'] = $candidate;
            $report['laravel_boot']['autoload_ok'] = false;
            $report['laravel_boot']['autoload_error'] = get_class($e).': '.$e->getMessage();
        }
        break;
    }
}

if ($loaded) {
    try {
        $app = require_once $rootDir.'/bootstrap/app.php';
        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
        $report['laravel_boot']['bootstrap_ok'] = true;
        $report['laravel_boot']['app_version'] = $app->version();

        try {
            $report['laravel_boot']['db_ok'] = (bool) Illuminate\Support\Facades\DB::connection()->getPdo();
        } catch (Throwable $e) {
            $report['laravel_boot']['db_ok'] = false;
            $report['laravel_boot']['db_error'] = get_class($e).': '.$e->getMessage();
        }

        try {
            $report['laravel_boot']['route'] = Illuminate\Support\Facades\Route::getRoutes()->count().' routes';
        } catch (Throwable $e) {
            $report['laravel_boot']['route_error'] = get_class($e).': '.$e->getMessage();
        }
    } catch (Throwable $e) {
        $report['laravel_boot']['bootstrap_ok'] = false;
        $report['laravel_boot']['bootstrap_error'] = get_class($e).': '.$e->getMessage();
        $report['laravel_boot']['bootstrap_trace'] = array_slice(
            explode("\n", $e->getTraceAsString()),
            0,
            12
        );
    }
}

// Tail the logs so we can see the real server-side error.
$report['logs'] = [];
foreach ([$rootDir.'/storage/logs/laravel.log', $rootDir.'/error_log', $publicDir.'/error_log'] as $logFile) {
    if (! is_readable($logFile)) {
        continue;
    }
    $lines = @file($logFile, FILE_IGNORE_NEW_LINES) ?: [];
    $report['logs'][$logFile] = [
        'size' => @filesize($logFile),
        'tail' => array_slice($lines, -40),
    ];
}

// Emit NDJSON to the debug session log file and to stdout.
$debugLogPath = getenv('DEBUG_LOG_PATH') ?: 'debug-f5d397.log';
$ndjson = json_encode([
    'sessionId' => 'f5d397',
    'runId' => 'probe',
    'hypothesisId' => 'server-probe',
    'location' => 'probe_host.php',
    'message' => 'Hosting server diagnostics',
    'data' => $report,
    'timestamp' => (int) (microtime(true) * 1000),
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

$written = @file_put_contents($debugLogPath, $ndjson."\n", FILE_APPEND);

echo "DEBUG_LOG_WRITTEN: ".var_export($written, true)." to ".$debugLogPath."\n";
echo "\n";
echo json_encode($report, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
echo "\n";
