<?php

include 'dbConfig.php';

class Mysql extends Dbconfig {

    public $dbConnection;
    public $dataSet;
    private $sqlQuery;

    protected $databaseName;
    protected $hostName;
    protected $userName;
    protected $passCode;

    public function __construct()    {
        $this->dbConnection = NULL;
        $this->sqlQuery = NULL;
        $this->dataSet = NULL;

        $dbConf = new Dbconfig();
        $this->databaseName = $dbConf->dbName;
        $this->hostName = $dbConf->serverName;
        $this->userName = $dbConf->userName;
        $this->passCode = $dbConf->passCode;
        $dbConf = NULL;
    }

    public function dbConnect()    {
        $this->dbConnection = mysql_connect($this->serverName,$this->userName,$this->passCode);
        mysql_select_db($this->databaseName,$this->dbConnection);
        return $this->dbConnection;
    }

    public function dbQuery($query) {
        return mysql_query($query);
    }

    public function dbClose() {
        mysql_close($this->dbConnection);
    }

?>
