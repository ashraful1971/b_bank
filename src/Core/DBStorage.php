<?php

namespace App\Core;

use App\Core\Contracts\DataStorage;
use PDO;
use PDOException;

class DBStorage implements DataStorage
{

    private static $instance = null;
    private $connection;

    /**
     * Set the db file path and name
     */
    public function __construct(string $host, string $dbname, string $username, string $password)
    {
        try {
            $this->connection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            dd("Error: " . $e->getMessage());
        }
    }

    /**
     * Create and return the class instance
     *
     * @return self
     */
    public static function init(string $host, string $dbname, string $username, string $password): self
    {
        if (!self::$instance) {
            self::$instance = new self($host, $dbname, $username, $password);
        }

        return self::$instance;
    }

    /**
     * Get all the records
     *
     * @param string $table_name
     * @return array
     */
    public function getAllRecords(string $table_name): array
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM $table_name");
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            return $stmt->fetchAll();
        } catch (PDOException $e) {
            dd("Error: " . $e->getMessage());
        }
    }

    /**
     * Create new record
     *
     * @param string $table_name
     * @param array $data
     * @return bool
     */
    public function addNewRecord(string $table_name, array $data): bool
    {
        if(isset($data['id'])){
            unset($data['id']);
        }

        try {
            $columns = implode(', ', array_keys($data));
            $placeholders = ':' . implode(', :', array_keys($data));

            $sql = "INSERT INTO $table_name ($columns) VALUES ($placeholders)";
            $stmt = $this->connection->prepare($sql);

            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            dd("Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update existing record
     *
     * @param string $table_name
     * @param array $data
     * @param mixed $id
     * @return bool
     */
    public function updateRecord(string $table_name, array $data, mixed $id): bool
    {
        try {
            if (isset($data['id'])) {
                unset($data['id']);
            }

            $set = [];

            foreach ($data as $key => $value) {
                $set[] = "$key='$value'";
            }

            $set_string = implode(', ', $set);

            $sql = "UPDATE $table_name SET $set_string WHERE id=:id";
            $stmt = $this->connection->prepare($sql);

            $stmt->bindValue(':id', $id);
            $id = $id;

            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            dd("Error: " . $e->getMessage());
            return false;
        }
    }
}
