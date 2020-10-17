<?php


include 'GospelTranslator.php';

$db = new GospelTranslator();

//getting role name
$result = $db->getRoleName(1);
echo $result;
echo '<br/>';

//adding user
$result = $db->addUser(7293333328472, 'godly', 1, 'testpassword', 'sldkjfs');
echo $result;
echo '<br/>';

//checking credentials
$result = $db->canAllowLogin(7293333328472, 'testpassword');
if ($result)
echo '<br/>login';
else
echo '<br/>block';

//adding need
$result = $db->addTransReq(1, 1, 1, "godly t alias", "my comments");
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
?>
