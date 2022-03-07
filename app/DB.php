<?php

declare(strict_types=1);

namespace App;

use PDO;

/**
 * @mixin PDO
 */
class DB
{
    private \PDO $pdo;

    public function __construct(protected Config $config)
    {
        try {
            $this->pdo = new \PDO(
                $config->db['driver'] . ':host=' . $config->db['host'] . ';dbname=' . $config->db['database'],
                $config->db['user'],
                $config->db['pass'],
                $config->options
            );
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), $e->getCode());
        }
    }

    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this->pdo, $name], $arguments);
    }
}
