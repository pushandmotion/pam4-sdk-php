<?php

// Load the Composer autoloader
$autoloadPath = dirname(__DIR__).'/vendor/autoload.php';

if (!file_exists($autoloadPath)) {
    fwrite(STDOUT, "Composer is not set up properly, please run 'composer install'.\n");

    exit;
}

require $autoloadPath;
