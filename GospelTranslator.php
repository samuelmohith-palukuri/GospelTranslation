<?php

include 'mySql.php';

class GospelTranslator {

    protected $db;

    function __construct() {
        $this->db = new mySql();
        $this->db->dbConnect();
    }

    //get the role of a user
    function getRole($userID) {
        $result = $this->db->dbQuery('Select roleID from User where userID=' . $userID);
        if ($result->num_rows > 0) {
            $finalResult = $result->fetch_assoc();
            return $finalResult['roleID'];
        } else return -1;
    }

    //get the role name of a role id
    function getRoleName($roleID) {
        $result = $this->db->dbQuery('Select roleName from role where roleID=' . $roleID);
        if ($result->num_rows > 0) {
            $finalResult = $result->fetch_assoc();
            return $finalResult['roleName'];
        } else return -1;
    }

    //function to add a user to system
    function addUser($phone, $name, $roleID, $password, $email) {
        $userValues = array('phoneNumber' => $phone,
                        'name' => $name,
                        'roleID' => $roleID,
                        'password' => md5($password),
                        'emailID' => $email);

        $userID = $this->db->dbInsert('User', $userValues);
        return $userID;
    }

    //function to get user profile of a user
    function getUser($phone) {
        $userFetch = $this->db->dbQuery('select * from User where phoneNumber=' . $phone);
        if ($userFetch->num_rows > 0) {
            $user = $userFetch->fetch_assoc();
            return $user;
        } else return -1;
    }

    //function to authenticate a user
    function canAllowLogin($phone, $password) {
        $user = $this->getUser($phone);
        if (is_numeric($user) && $user == -1) return false;
        else {
            $hashedPassword = md5($password);
            if ($user['is_active'] == TRUE && $hashedPassword == $user['password'])
                return true;
            else return false;
        }
    }

    //function to add translation request
    function addTransReq($requestorID, $srcLangID, $targetLangID, $sourceText, $comments) {
        $tableValues = array('requestorID' => $requestorID,
                            'sourceLanguageID' => $srcLangID,
                            'targetLanguageID' => $targetLangID,
                            'sourceText' => $sourceText,
                            'commentsRequestor' => $comments,
                            'transStatusID' => 1);
        return $this->db->dbInsert('transReq', $tableValues);
    }
}

?>
