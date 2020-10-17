<?php


include 'GospelTranslator.php';

$db = new GospelTranslator();

$result = $db->getRoleName(1);
echo $result;

$result = $db->addUser('User', 7293333328472, 'godly', 1, 'testpassword', 'sldkjfs');
echo $result;

$result = $db->canAllowLogin(7293333328472, 'testpassword');
if ($result)
echo 'login';
else
echo 'block';
?>
