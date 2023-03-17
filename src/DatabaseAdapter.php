<?php

namespace Psn\CliTasks;

use PDO;

class DatabaseAdapter
{
    protected $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function fetchAll($table)
    {
        return $this->connection->query('select * from ' . $table)->fetchAll();
    }

    public function query($sql, $params = [])
    {
        return $this->connection->prepare($sql)->execute($params);
    }
}
