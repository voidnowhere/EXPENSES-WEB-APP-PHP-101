<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

const VIEWS_PATH = __DIR__ . '/../views' . DIRECTORY_SEPARATOR;

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$router = new App\Router();

$router
    ->get('/', [App\Controllers\HomeController::class, 'index'])
    ->get('/invoice', [App\Controllers\InvoiceController::class, 'index'])
    ->get('/invoice/upload', [App\Controllers\InvoiceController::class, 'upload'])
    ->post('/invoice/upload', [App\Controllers\InvoiceController::class, 'upload']);

(new \App\App(
    $router,
    ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']],
    new \App\Config($_ENV)
))->run();
