<?php


include 'GospelTranslator.php';

$db = new GospelTranslator();

$result = $db->getRoleName(1);
echo $result;
echo '<br/>';

$result = $db->addUser(7293333328472, 'godly', 1, 'testpassword', 'sldkjfs');
echo $result;
echo '<br/>';

$result = $db->canAllowLogin(7293333328472, 'testpassword');
if ($result)
echo '<br/>login';
else
echo '<br/>block';

$result = $db->addTransReq(1, 1, 1, "godly t alias", "my comments");
echo '<br/>translation request added';
?>
