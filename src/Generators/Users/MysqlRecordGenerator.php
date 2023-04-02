<?php

namespace Supermetrics\Ambassador\Generators\Users;

use PDO;
use PDOStatement;

class MysqlRecordGenerator
{
    private const TABLE = 'users';
    private const PER_CHUNK = 100;

    /**
     * @param PDO   $connection
     * @param array $data
     *
     * @return array
     * Final result might be:
     *
     * INSERT INTO users (id, name) VALUES (1,'Farshid'),(2,'ozzy'),...,(100,'freddie');
     * INSERT INTO users (id, name) VALUES (101,'James'),(102,'lars'),...,(200,'hammet');
     */
    public function insertQueryBuilder(PDO $connection, array $data): array
    {
        /**
         * Data will be separated into chunks.
         */
        $chunkedData = array_chunk($data, self::PER_CHUNK);
        $queries = [];

        foreach ($chunkedData as $chunk) {
            $values = '';
            foreach ($chunk as $item) {
                /**
                 * quote method will take care of SQL Injection.
                 */
                $name = $connection->quote($item['name']);
                $id = $connection->quote($item['id']);

                $values .= "($id,$name),";
            }
            /**
             * Last , should be removed.
             */
            $values = rtrim($values, ",");
            $queries[] = "INSERT INTO " . self::TABLE . " (id, name) VALUES $values";
        }

        return $queries;
    }

    /**
     * @param string|null $id
     *
     * @return string
     */
    public function selectQueryBuilder(string $id = null): string
    {
        $query =  "SELECT * FROM " . self::TABLE;

        if ($id !== null) {
            $query .= " WHERE id = " . "'$id'";
        }

        return $query;
    }
}
