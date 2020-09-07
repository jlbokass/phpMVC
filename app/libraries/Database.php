<?php

/**
 * Class Database
 *
 * PDO database Class
 * Connect to Database
 * Create prepared statements
 * Bind values
 * Return rows and results
 */
class Database
{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $dbh;
    private $stmt;
    private $error;

    public function __construct()
    {
        // Set DNS
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        // Create a PDO instance
        try {

            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);

        } catch (PDOException $e) {

            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    /**
     * Prepare statement with query
     *
     * @param $sql
     *
     * @return void
     */
    public function query($sql)
    {
        $this->stmt = $this->dbh->query($sql);
    }

    /**
     * Bind values
     * 
     * @param mixed $param
     * @param mixed $value
     * @param mixed $type
     *
     * @return void
     */
    public function bind($param, $value, $type)
    {
        if (is_null($type)) {

            switch ($type) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }

        $this->stmt->binValue($param, $value, $type);
    }

    /**
     * Execute the prepare statement
     *
     * @return mixed
     */
    public function execute()
    {
        return $this->stmt->execute();
    }

    /**
     * Get result set as array of objects
     *
     * @return mixed
     */
    public function resultSet()
    {
        $this->execute();

        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Get Single record as object
     *
     * @return mixed
     */
    public function single()
    {
        $this->execute();

        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * get row count
     *
     * @return mixed
     */
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }
}