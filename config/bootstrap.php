<?php

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
const APP_ROOT = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;

try {
    return \App\Factory\AppFactory::create();
} catch (\DI\DependencyException|\DI\NotFoundException $e) {
    error_log($e->getMessage());
}