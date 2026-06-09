<?php

$logPath = __DIR__.'/storage/logs/laravel.log';
if (file_exists($logPath)) {
    $content = file_get_contents($logPath);
    // Split by "Stack trace" to get the last error message clearly
    $parts = explode('Stack trace', $content);
    $lastPart = end($parts);
    if (count($parts) > 1) {
        $beforeLast = $parts[count($parts)-2];
        echo $beforeLast . "\nStack trace (truncated)...\n";
    } else {
        echo $content;
    }
} else {
    echo "Log file not found at: " . $logPath . "\n";
}
