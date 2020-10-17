<?php

include 'mySql.php';

class GospelTranslator {

    protected $db;
    public static $transStatusNew = 1;
    public static $transStatusInProgress = 2;
    public static $transStatusCompleted = 3;
    public static $transStatusAccepted = 4;
    public static $transStatusRejected = 5;

    public static $userRoleRequestor = 1;
    public static $userRoleTranslator = 2;
    public static $userRoleAdmin = 3;

    function __construct() {
        $this->db = new mySql();
        $this->db->dbConnect();
    }

    function __destruct() {
        if ($this->db) $this->db->dbClose();
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

    //function to get all languages
    function getLang() {
        $query = 'select * from language';
        $languageRes = $this->db->dbQuery($query);

        $languages = array();
        while ($language = $languageRes->fetch_assoc()) {
            array_push($languages, array('langID' => $language['langID'],
                                        'languageName' => $language['languageName']));
        }
        return $languages;
    }

    //function to add proficient languages to translator
    function addTransLang($translatorID, $langID) {
        $query = 'select * from translatorLangMap where userID=' . $translatorID . ' and langID=' . $langID;
        $transLangRes = $this->db->dbQuery($query);
        if ($transLangRes->num_rows > 0) return -1;

        $tableValues = array('userID' => $translatorID,
                            'langID' => $langID,
                            'approvalStatus' => 0);
        return $this->db->dbInsert('translatorLangMap', $tableValues);
    }

    //function to approve a proficient language to translator
    function approveTransLang($approverID, $translatorID, $langID) {
        $role = $this->getRole($approverID);
        if ($role != GospelTranslator::$userRoleAdmin) return -1;
        if (!$translatorID) return -1;

        $tableValues = array('approverID' => $approverID,
                            'approvalStatus' => true);

        $updateRow = array(array('columnName' => 'userID',
                                 'columnVal' => $translatorID),
                           array('columnName' => 'langID',
                                'columnVal' => $langID));
        return $this->db->dbUpdate('translatorLangMap', $updateRow, $tableValues);
    }

    //function to get the translation requests
    function getTransReq($translatorID) {
        $query = 'select * from translatorLangMap where userID=' . $translatorID . ' and approvalStatus=true';
        $transLangRes = $this->db->dbQuery($query);

        if ($transLangRes->num_rows <= 0) return NULL;

        $transLangList = '';
        while ($transLang = $transLangRes->fetch_assoc()) {
            $transLangList .= ($transLang['langID'] . ',');
        }
        $transLangList = substr($transLangList, 0, -1);

        $query = 'select * from transReq where sourceLanguageID in (' . $transLangList . ') and targetLanguageID in (' . $transLangList . ')';

        $requests = $this->db->dbQuery($query);
        $translationReq = array();

        while ($req = $requests->fetch_assoc()) {
            array_push($translationReq, $req);
        }
        return $translationReq;
    }

    //function to add translation
    function addTranslation($transReqID, $translatorID, $translatedText, $transComments, $submit = false) {

        $tableValues = array(
                            'translatorID' => $translatorID,
                            'translatedText' => $translatedText,
                            'commentsTranslator' => $transComments);
        if ($submit)
            $tableValues['transStatusID'] = GospelTranslator::$transStatusCompleted;
        else $tableValues['transStatusID'] = GospelTranslator::$transStatusInProgress;

        return $this->db->dbUpdate('transReq', array(array('columnName' => 'transReqID', 'columnVal' => $transReqID)), $tableValues);
    }
}

?>
