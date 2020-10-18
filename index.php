<?php


include 'GospelTranslator.php';

$db = new GospelTranslator();

//getting role name
$result = $db->getRoleName(GospelTranslator::$userRoleRequestor);
echo $result;
echo '<br/>';

//adding user
$userPhone = rand();
$resultUser = $db->addUser($userPhone, 'gospel translate', 'testpassword', 'sldkjfs');
echo 'Created User: ' . $resultUser;
echo '<br/>';

//checking credentials
$result = $db->canAllowLogin($userPhone, 'testpassword');
if ($result)
echo '<br/>login';
else
echo '<br/>block';

//adding need
$result = $db->addTransReq($resultUser, 1, 1, "gospel translate", "my comments");
echo '<br/>translation request added';

echo '<br/>';


echo '<br/>';

//getting all languages
$langs = $db->getLang();
echo "languages<br/>";
foreach($langs as $lang){
echo "find ";
echo $lang['langID'] . ' - ' . $lang['languageName'] . '<br/>';
}

//getting trans needs for a translator
echo "<br/> getting trans reqs";
$reqs = $db->getTransReq(1);
foreach($reqs as $req) {
echo $req['sourceText'];
echo '<br/>';
}

//adding a translation
$reqs = $db->addTranslation(1, 1, 'this is gosepl translate', 'translated', false);
echo  'translation done';
echo '<br/>';

//adding language for a translator
$ret = $db->addTransLang($resultUser, 1);
echo 'adding trans lag res = ' . $ret;
echo '<br/>';

//approving language for a translator
$ret = $db->approveTransLang(1, $resultUser, 1);
echo 'approving trans lag res = ' . $ret;
echo '<br/>';
?>
