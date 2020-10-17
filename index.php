<?php


include 'GospelTranslator.php';

$db = new GospelTranslator();

$result = $db->getRoleName(1);
echo $result;

$result = $db->addUser('72938472', 'godly', '0', 'slkdjfs', 'sldkjfs');
echo $result;

?>
