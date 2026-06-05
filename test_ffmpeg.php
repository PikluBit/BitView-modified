<?php
header('Content-Type: text/plain; charset=utf-8');
echo "ffmpeg output:\n";
echo shell_exec('ffmpeg -version 2>&1');

echo "\nffprobe output:\n";
echo shell_exec('ffprobe -version 2>&1');

echo "\nPHP disable_functions:\n";
echo ini_get('disable_functions') . "\n";

echo "\nWorking dir: " . getcwd() . "\n";

echo "\nDocument root: " . 
    (isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'] : 'N/A') . "\n";
