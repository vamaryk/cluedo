<?php
session_start();
// Уничтожение сессии
session_destroy();
header('Location: index.php');
exit;
?>