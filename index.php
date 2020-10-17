<?php


include 'GospelTranslator.php';

$db = new GospelTranslator();

$result = $db->getRoleName(1);
echo $result;
?>
