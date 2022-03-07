<?php

declare(strict_types=1);

namespace App;

use PDO;

/**
 * @property-read ?array $db
 * @property-read ?array $options
 */
class Config
{
    protected array $config = [];

    public function __construct(array $env)
    {
        $this->config = [
            'db' => [
                'host' => $env['DB_HOST'],
                'user' => $env['DB_USER'],
                'pass' => $env['DB_PASS'],
                'database' => $env['DB_DATABASE'],
                'driver' => $env['DB_DRIVER'] ?? 'mysql'
            ],
            'options' => [
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ],
        ];
    }

    public function __get(string $name)
    {
        return $this->config[$name] ?? null;
    }
}
