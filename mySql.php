<?php

include 'dbConfig.php';

class mySql extends Dbconfig {

    public $dbConnection;
    public $dataSet;
    private $sqlQuery;

    protected $databaseName;
    protected $serverName;
    protected $userName;
    protected $passCode;

    public function __construct()    {
        $this->dbConnection = NULL;
        $this->sqlQuery = NULL;
        $this->dataSet = NULL;

        $dbConf = new Dbconfig();
        $this->databaseName = $dbConf->dbName;
        $this->serverName = $dbConf->serverName;
        $this->userName = $dbConf->userName;
        $this->passCode = $dbConf->passCode;
    }

    public function dbConnect()    {
        $this->dbConnection = new mysqli($this->serverName, $this->userName, $this->passCode, $this->databaseName);
        if (!$this->dbConnection)
            die('Could not connect to Database');
        return $this->dbConnection;
    }

    public function dbQuery($query) {
        return $this->dbConnection->query($query);
    }

    public function dbInsert($table, $tableValues) {
        $query = 'insert into ' . $table . ' ';

        $columns = '';
        $values = '';
        foreach ($tableValues as $key => $value) {
            $columns .= ($key . ',');
            if (!is_numeric($value)) $value = ('"' . $value . '"');
            $values .= ($value . ',');
        }
        $columns = substr($columns, 0, -1);
        $values = substr($values, 0, -1);
        $query .= ('(' . $columns . ') VALUES ');
        $query .= ('(' . $values . ') ');
        $res = $this->dbQuery($query);

        return $res;
    }

    public function dbClose() {
        $this->dbConnection->close();
    }
}
?>
