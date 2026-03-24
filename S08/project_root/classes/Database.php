<?php
// classes/Database.php

class Database
{
    // Holds the single instance of this class (Singleton pattern)
    private static ?Database $instance = null;

    // The underlying PDO connection
    private PDO $pdo;

    /**
     * Private constructor so it cannot be called from outside.
     * It reads config, builds the DSN, and connects using PDO.
     * If connection fails, it logs the error and throws a generic exception.
     */
    private function __construct()
    {
        // Load DB configuration array from config file
        $config = require __DIR__ . '/../config/database.php';

        // Build DSN string for MySQL
        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";

        try {
            // Create PDO instance with options:
            // - Throw exceptions on error
            // - Return associative arrays for fetch()
            // - Disable emulated prepares for better security
            $this->pdo = new PDO($dsn, $config['username'], $config['password'], [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            // Log the detailed error message to a file (for developers)
            error_log('DB connection failed: ' . $e->getMessage());

            // Throw a generic exception with a user-friendly message
            throw new Exception('Cannot connect to the database. Please try again later.');
        }
    }

    /**
     * Public static method to get the single Database instance.
     * If it does not exist, create it.
     */
    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Get the underlying PDO connection.
     * Use this only if you need raw PDO functions.
     */
    public function getConnection(): PDO
    {
        return $this->pdo;
    }

    /**
     * Execute a SQL query with optional parameters and return PDOStatement.
     * It uses prepared statements to avoid SQL injection.
     * On error, logs details and throws a generic exception.
     */
    public function query(string $sql, array $params = []): PDOStatement
    {
        try {
            // Prepare SQL statement
            $stmt = $this->pdo->prepare($sql);

            // Execute with parameters (if any)
            $stmt->execute($params);

            return $stmt;
        } catch (PDOException $e) {
            // Log detailed error with SQL
            error_log('DB query failed: ' . $e->getMessage() . ' | SQL: ' . $sql);

            // Throw generic exception to the caller (controller)
            throw new Exception('Database error occurred.');
        }
    }

    /**
     * Helper: fetch all rows from a query as an array of associative arrays.
     */
    public function fetchAll(string $sql, array $params = []): array
    {
        return $this->query($sql, $params)->fetchAll();
    }

    /**
     * Helper: fetch a single row (or false if no row).
     */
    public function fetch(string $sql, array $params = []): array|false
    {
        return $this->query($sql, $params)->fetch();
    }

    /**
     * Helper: insert a row into the given table.
     * $data is an associative array: ['column' => 'value', ...].
     * Returns the last inserted ID as string.
     */
    public function insert(string $table, array $data): string
    {
        // Build column list: "name, email"
        $columns = implode(', ', array_keys($data));

        // Build placeholders: "?, ?"
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        // Final SQL: INSERT INTO table (col1,col2) VALUES (?,?)
        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";

        // Execute with the values of $data
        $this->query($sql, array_values($data));

        // Return last inserted ID
        return $this->pdo->lastInsertId();
    }

    /**
     * Helper: update rows in the given table.
     * $data is an associative array of columns to update.
     * $where is a string like "id = ?".
     * $whereParams are the values for the WHERE clause.
     * Returns the number of affected rows.
     */
    public function update(string $table, array $data, string $where, array $whereParams = []): int
    {
        // Build SET part: "name = ?, email = ?"
        $set = implode(' = ?, ', array_keys($data)) . ' = ?';

        $sql = "UPDATE {$table} SET {$set} WHERE {$where}";

        // Merge values to match placeholders: data values + where values
        $params = array_merge(array_values($data), $whereParams);

        return $this->query($sql, $params)->rowCount();
    }

    /**
     * Helper: delete rows from the given table.
     * $where is a string like "id = ?".
     * $params are the values for the WHERE clause.
     * Returns the number of affected rows.
     */
    public function delete(string $table, string $where, array $params = []): int
    {
        $sql = "DELETE FROM {$table} WHERE {$where}";

        return $this->query($sql, $params)->rowCount();
    }
}
