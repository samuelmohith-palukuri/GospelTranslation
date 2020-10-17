<?php

include 'mySql.php';

class GospelTranslator {

    protected $dbConnection;

    function __construct() {
        $db = new mySql();
        $this->dbConnection = $db->dbConnect();
    }
    function getRole($userID) {
        $result = $this->dbConnection->query('Select roleID from User where userID=' . $userID);
        if ($result->num_rows > 0) {
            $finalResult = $result->fetch_assoc();
            return $finalResult['roleID'];
        } else return -1;
    }

    function getRoleName($roleID) {
        $result = $this->dbConnection->query('Select roleName from role where roleID=' . $roleID);
        if ($result->num_rows > 0) {
            $finalResult = $result->fetch_assoc();
            return $finalResult['roleName'];
        } else return -1;
    }
}

?>
