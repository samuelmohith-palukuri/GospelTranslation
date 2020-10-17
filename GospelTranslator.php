<?php

include 'mySql.php';

class GospelTranslator {

    protected $db;

    function __construct() {
        $this->db = new mySql();
        $this->db->dbConnect();
    }

    function getRole($userID) {
        $result = $this->db->dbQuery('Select roleID from User where userID=' . $userID);
        if ($result->num_rows > 0) {
            $finalResult = $result->fetch_assoc();
            return $finalResult['roleID'];
        } else return -1;
    }

    function getRoleName($roleID) {
        $result = $this->db->dbQuery('Select roleName from role where roleID=' . $roleID);
        if ($result->num_rows > 0) {
            $finalResult = $result->fetch_assoc();
            return $finalResult['roleName'];
        } else return -1;
    }

    function addUser($phone, $name, $roleID, $password, $email) {
        $userValues = array('phoneNumber' => $phone,
                        'name' => $name,
                        'roleID' => $roleID,
                        'password' => $password,
                        'emailID' => $email);

        $userID = $this->db->dbInsert($table, $userValues);
        return $userID;
    }
}

?>
