<?php
/**
 * Connectors for CRUD example database.
 * 
 * @author Logan Miller
 */
namespace CRUD\Database;

use PDO;

class Connection {
    /**
     * The database hostname.
     * 
     * @var string
     */
    private $host;

    /**
     * The database username.
     * 
     * @var string
     */
    private $user;

    /**
     * The database password.
     * 
     * @var string
     */
    private $pass;

    /**
     * The database schema.
     * 
     * @var string
     */
    private $db;

    /**
     * The database character set.
     * 
     * @var string
     */
    private $charset;

    /**
     * Construct default database connection to CRUD database.
     */
    public function __construct()
    {
        $this->host    = '127.0.0.1';
        $this->user    = 'test_user';
        $this->pass    = '!Test1234Password!';
        $this->db      = 'crud';
        $this->charset = 'utf8mb4';
    }

    public function connect()
    {
        $dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            return new \PDO($dsn, $this->user, $this->pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    /**
     * Prepared PDO statement.
     * 
     * @param string $sql
     */
    public function prepare($sql, array $params) {
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Query statement.
     * 
     * @param string $sql
     */
    public function query($sql) {
        return $this->connect()->query($sql);
    }
}