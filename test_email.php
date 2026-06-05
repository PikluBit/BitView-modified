<?php
require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";

require $_SERVER['DOCUMENT_ROOT']."/404.php";
exit();

$Emailer = new Email();

$Emailer->To = "supapowii@gmail.com";
$Emailer->To_Name = "Jan";
$Emailer->Subject = "Test Email";

$Emailer->send_email("Hi this is a god damn test duuuude");