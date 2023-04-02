<?php

namespace Supermetrics\Ambassador\Drivers;

use PDO;
use Exception;
use PDOException;
use Supermetrics\Ambassador\Contracts\DriverInterface;
use Supermetrics\Ambassador\Contracts\DriverConnectionInterface;
use Supermetrics\Ambassador\Exceptions\MySqlQueryExecutionException;

class MysqlDriver implements DriverInterface, DriverConnectionInterface
{
    private const BASE_GENERATOR_NAMESPACE = 'Supermetrics\Ambassador\Generators\\';
    private const GENERATOR_CLASS_SUFFIX = 'MysqlRecordGenerator';
    protected PDO $connection;
    public function connect(): bool
    {
        $mysqlConnectionConfig = config('database')['connections']['mysql'];
        try {
            $options = [
                PDO::ATTR_EMULATE_PREPARES   => false,
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ];
            $this->connection = new PDO(
                "mysql:host=".$mysqlConnectionConfig['host'].";dbname=".$mysqlConnectionConfig['database'].";charset=".$mysqlConnectionConfig['charset']."",
                $mysqlConnectionConfig['username'],
                $mysqlConnectionConfig['password'],
                $options
            );

            return true;
        } catch(PDOException $ex) {
            return false;
        }
    }

    public function findById(string $id, string $entityType): array
    {
        $mysqlRecordGenerator = $this->getMySqlGenerator($entityType);
        $selectQuery = $mysqlRecordGenerator->selectQueryBuilder($id);
        try {
            $statement = $this->connection->query($selectQuery);
            $statement->execute();

            $result = $statement->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            $result = [];
        }

        return $result;
    }

    public function findAll(string $entityType): array
    {
        $mysqlRecordGenerator = $this->getMySqlGenerator($entityType);
        $selectQuery = $mysqlRecordGenerator->selectQueryBuilder();

        try {
            $statement = $this->connection->query($selectQuery);
            $statement->execute();

            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            $result = [];
        }

        return $result;
    }

    /**
     * @param array  $payload
     * @param string $entityType
     */
    public function store(array $payload, string $entityType): void
    {
        $mysqlRecordGenerator = $this->getMySqlGenerator($entityType);
        $insertQuery = $mysqlRecordGenerator->insertQueryBuilder($this->connection, $payload);

        if (count($insertQuery) >= 1) {
            try {
                $this->connection->beginTransaction();

                foreach ($insertQuery as $query) {
                    $statement = $this->connection->query($query);
                    $statement->execute();
                }

                $this->connection->commit();
            } catch (Exception $ex) {
                $this->connection->rollBack();
            }
        }
    }

    private function getMySqlGenerator(string $entityType): mixed
    {
        return new (self::BASE_GENERATOR_NAMESPACE . ucfirst($entityType) . '\\' . self::GENERATOR_CLASS_SUFFIX);
    }
}
