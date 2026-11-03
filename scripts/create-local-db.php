<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

(Dotenv\Dotenv::createImmutable(dirname(__DIR__)))->safeLoad();

$host = getenv('DB_HOST') ?: '127.0.0.1';
$port = getenv('DB_PORT') ?: '3306';
$user = getenv('DB_USERNAME') ?: 'root';
$pass = getenv('DB_PASSWORD') ?: '';
$name = $argv[1] ?? 'webfocus_cms5';

$dsn = sprintf('mysql:host=%s;port=%s', $host, $port);
$pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
$pdo->exec(
    sprintf(
        'CREATE DATABASE IF NOT EXISTS `%s` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci',
        str_replace('`', '``', $name)
    )
);

fwrite(STDOUT, "Database `{$name}` is ready.\n");
