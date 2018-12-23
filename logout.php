<?php
session_start();
$res = setcookie('usuario', '', time() - 3600);
session_destroy();
header("Location: /");
exit();
?>