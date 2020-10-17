<?php


include 'GospelTranslator.php';

$db = new GospelTranslator();

//getting role name
$result = $db->getRoleName(GospelTranslator::$userRoleRequestor);
echo $result;
echo '<br/>';

//adding user
$resultUser = $db->addUser(rand(), 'gospel translate', 1, 'testpassword', 'sldkjfs');
echo $resultUser;
echo '<br/>';

//checking credentials
$result = $db->canAllowLogin(7293333328472, 'testpassword');
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
foreach($langs as $lang){
echo "find";
echo $lang['langID'] . ' - ' . $lang['languageName'];
}

//getting trans needs for a translator
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
$ret = $db->addTransLang(1, 1);
echo 'adding trans lag res = ' . $ret;
echo '<br/>';

//approving language for a translator
$ret = $db->approveTransLang(1, $resultUser, 1);
echo 'approving trans lag res = ' . $ret;
echo '<br/>';
?>
